<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\Contract\OrderService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    /**
     * @param \App\Repositories\UserRepository $userRepository
     * @param \App\Repositories\ProductRepository $productRepository
     */
    public function __construct(
        private UserRepository $userRepository,
        private ProductRepository $productRepository,
        private OrderService $orderService,
    ) {
    }
    /**
     * Display the order creation page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): ViewFactory|View
    {
        $customers = $this->userRepository->all();
        $products = $this->productRepository->all();

        return view('order.create', [
            'products' => $products,
            'customers' => $customers
        ]);
    }

    /**
     * Create an order if there is no order attached on the request yet
     * Then associate the customer and attach the product while populating amount data to the order_item pivot
     *
     * @param \App\Http\Requests\OrderCreateRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function store(OrderCreateRequest $request)
    {

        $validated = $request->validated();
        $order = $this->orderService->createOrUpdate($validated);


        return redirect("/")->with('message', 'The order has been saved.');
    }
}
