<?php

namespace App\Http\Middleware;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderResolverMiddleware
{
    /**
     * Find if there is already an order with the same Need by date and containing products with the same typ and belonging to the same customer.
     * Attach the existing order to the request data
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = Product::find($request->input("product"));

        $order = Order::whereHas("products", function ($query) use ($product) {
            $query->where("type_id", $product->type_id);
        })
            ->whereDate("need_by", "=", $request->input("need_by"))
            ->where('customer_id', $request->input('customer_id'))
            ->where('is_processed', '<>', true)
            ->first();

        $request->merge(['foundOrder' => $order]);

        return $next($request);
    }
}
