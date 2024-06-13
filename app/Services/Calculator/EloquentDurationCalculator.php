<?php
namespace App\Services\Calculator;

use App\Models\Order;

class EloquentDurationCalculator
{
    /**
     * Calculate the factoring duration for an order
     * @param \App\Models\Order $order
     * @return \App\Models\Order
     */
    public function process(Order $order): Order
    {
        $productionSpeed = $order->products->first()?->type->production_speed ?? 0;
        $factoringDuration = $order->total_products / $productionSpeed;
        $order->factoring_duration = $factoringDuration;
        return $order;
    }
}
