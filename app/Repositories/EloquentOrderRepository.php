<?php
namespace App\Repositories;

use App\Models\Order;

class EloquentOrderRepository implements OrderRepository
{

    /**
     * @param \App\Models\Order $order
     */
    public function __construct(
        private Order $order
    ) {
    }
    /**
     *
     * @param array $data
     * @return object
     */
    public function createOrUpdate(array $data): object
    {
        $order = $this->getBy($data);

        if ($order == null) {
            $order = new Order([
                'need_by' => $data['need_by'],
            ]);
            $order->customer()
                ->associate($data['customer'])
                ->save();
        }

        $order->products()->attach($data['product'], ['amount' => $data['amount']]);

        return $order;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->order->all();
    }

    /**
     *
     * @param array $data
     * @return object
     */
    public function create(array $data)
    {
        return $this->order->create($data);
    }

    /**
     *
     * @param int $id
     * @return object|null
     */
    public function find(int $id)
    {
    }
    /**
     * Summary of getBy
     *
     * @param array $data
     * @return object|null
     */
    public function getBy(array $data): object|null
    {
        return $this->order->whereHas("products", function ($query) use ($data) {
            $query->where("type_id", $data['type_id']);
        })
            ->whereDate("need_by", "=", $data['need_by'])
            ->where('customer_id', $data['customer_id'])
            ->where('is_processed', '<>', true)
            ->first();
    }
    /**
     * Retrieve all the orders that have products for schedule purpose
     * sorted by
     *  - need_by asc first,
     *  - then product_types.production_speed desc
     *
     * @return \Illuminate\Support\Collection
     */
    public function listOrdersToSchedule(): \Illuminate\Support\Collection
    {
        $orders = $this->order->join('order_item', 'orders.id', '=', 'order_item.order_id')
            ->join('products', 'order_item.product_id', '=', 'products.id')
            ->join('product_types', 'product_types.id', '=', 'products.type_id')
            ->with(['customer'])
            ->withWhereHas(
                'products',
                function ($query) {
                    return $query->with(['type']);
                }
            )
            ->withSum('products as total_products', 'order_item.amount')
            ->orderBy("need_by", "asc")
            ->orderBy('product_types.production_speed', 'desc')
            ->get();

        return $orders;
    }
}
