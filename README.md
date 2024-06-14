

## Factoring Schedule

> **Note:** This repository has been powered by  [Laravel Sail](https://laravel.com/docs/11.x/sail).

## Overall

### Assumptions

The solution needs to be scalable and configurable


### Approach

Use of the repository pattern for data access
- Interface for generic repository `App\Repositories\Repository`
- A basic interface extending the generic one for each model. e.g `App\Repository\OrderRepository`
- An eloquent specific class implementing the basic interface for each model. e.g `App\Repository\EloquentOrderRepository`

In controllers and services, the basic repository interfaces are injected through dependency injection to the controllers

They are resolved in `App\Providers\AppserviceProvider` by binding them and pointing them to the corresponding `Eloquent[Entity]Repository` class

In order to detach business logics form the controler as well, I adopted the use of services. Same approach as the repository pattern:

- Generic interface for each service. e.g `App\Services\Contract\OrderService`
- A corresponding Eloquent specific service implementing the generic interface for each. e.g `App\Services\EloquentOrderService`

These service interfaces are also injected to controllers through dependency injection. And they are resolved through binding in `App\Providers\AppserviceProvider` and pointing them to their respective Eloquent service class for now.

> **Note:** In case we switch to other data source, we could just create Services and Repositories specific to that new source and implement the corresponding basic service or repository signature

Addition of a configuration file for the schedule process `app/config/scheduling.php`. The scheduling changeover delay is the only value provided by this config so far. But we can add any scheduling related values

## Data Design

### Assumptions

- The processing duration should be in the product type table.
- Add the amount of products in the order_item pivot

### Approach

```
product_types
    id - integer
    name - string
    production_speed - integer

products
    id - integer
    type_id - integer # foreign key
    name - string


users
    id - integer
    name - string
 
order
    id - integer
    customer_id - integer # foreign key users
    need_by - date
 
order_item # pivot
    order_id - integer # foreign key 
    product_id - integer # foreign key
    amount - integer
```

## Order creation

### Assumptions

Simple form with 

- customer -> select
- product -> select
- amount -> input of type number
- need by date -> input of type date

to limit the addition of products of different types to the same order

### Approach

Involved route: `/orders/create`

Since the form allows to select only one product, I adopted the ***create or update*** approach, identifying an order by its `customer, product type (through already attached products), need by date`. 

When adding a product with a certain amount to an existing order:

- if there are a certain amount of that product in the order, the inputted amount is added up to the existing amount.
- else attach the product with the inputted amount.

The service involved is `App\Services\EloquentOrderService` through its `createOrUpdate()` method, which is calling `App\Repository\EloquentOrderRepository::createOrUpdate()` method.

## Schedule

### Assumptions

Display the schedule in a timeline with, per order :

- start date
- order sequence (order id)
- overall amount of products to process
- overall production duration (e.g *1.5 hours*)
- details (products with according amount)
- end date 
- setup start date if there was a changeover

### Approach

The schedule is generated on the fly when visiting the schedule (or home) page (route `/`).

Basic algorithm prioritizing by :

- `need_by` asc
- then `product type production speed` desc

This will allow to schedule the production with the following order:
- `need_by` date ascending
- then in each `need_by` group, grouping the orders with products of same type in order to minimize overall changeover delay.

The service in charge is `App\Services\EloquentSchedulesService` through its `generate()` method.

The sorting is done by default in `App\Repositories\EloquentOrderRepository::listOrdersToSchedule()`. In addition a `App\Services\Calculator\DefaultSortCalculator` has been attached through dependency injection to `EloquentSchedulerService`. This default sort calculator does not do any sorting. But in the future, we could inject another sort calculator to have a better sorting and grouping
