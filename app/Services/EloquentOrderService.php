<?php
namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\Contract\OrderService;

class EloquentOrderService implements OrderService
{
    public function __construct(
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository,
        private UserRepository $userRepository
    ) {
    }

    /**
     * Summary of createOrDelete
     *
     * @param array $data
     * @return object
     */
    public function createOrUpdate(array $data): object
    {
        $customer = $this->userRepository->find($data["customer_id"]);
        $product = $this->productRepository->find($data["product"]);
        $data['type_id'] = $product->type_id;
        $data['product'] = $product;
        $data['customer'] = $customer;
        return $this->orderRepository->createOrUpdate($data);

    }
}
