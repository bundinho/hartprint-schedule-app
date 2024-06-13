<?php
namespace App\Services\Calculator;

use App\Models\Order;

class EloquentSchedulerDateCalculator
{
    /**
     * Calculate the dates for the whole schedule
     *
     * @param \App\Models\Order $order
     * @param mixed $startDate
     * @param mixed $previousProductTypeId
     * @return \App\Models\Order
     */
    public function process(Order $order, $startDate, &$previousProductTypeId): Order
    {
        $orderProductTypeId = $order->products->first()?->type->id;
        $orderProductType = $order->products->first()?->type->name;

        if ($previousProductTypeId !== null && $previousProductTypeId !== $orderProductTypeId) {
            $order->changeover_start_date = $startDate->format("Y-m-d H:i:s");
            $order->changeover_end_date = $startDate->addMinutes(config('scheduling.changeover.delay'))->format('Y-m-d H:i:s');
            $order->factoring_start_date = $order->changeover_end_date;
        } else {
            $order->factoring_start_date = $startDate->format('Y-m-d H:i:s');
        }
        $order->product_type = $orderProductType;
        $order->factoring_end_date = $startDate->addHours($order->factoring_duration)->format('Y-m-d H:i:s');


        $previousProductTypeId = $orderProductTypeId;

        return $order;
    }
}
