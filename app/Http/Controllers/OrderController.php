<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display the order creation page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): ViewFactory|View
    {
        $customers = User::orderBy("name", "asc")->get();
        $products = Product::orderBy('name', 'asc')->get();
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
        $request->get('foundOrder');
        $customer = User::find($request->get('customer_id'));
        $order = $request->get('foundOrder');

        if ($order === null) {
            $order = new Order([
                'need_by' => $request->get('need_by')
            ]);
            $order->customer()
                ->associate($customer)
                ->save();
        }

        $order->products()->attach($request->get('product'), ['amount' => $request->get('amount')]);

        return redirect("/orders")->with('success', 'The order has been saved.');
    }
}
