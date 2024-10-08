<?php
namespace App\Services;

use App\Models\Order;
use App\Repositories\EloquentOrderRepository;
use App\Services\Calculator\EloquentDurationCalculator;
use App\Services\Calculator\EloquentSchedulerDateCalculator;
use App\Services\Contract\SchedulerService;
use App\Services\Contract\SortCalculator;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentSchedulerService implements SchedulerService
{

    /**
     * Summary of __construct
     * @param \App\Repositories\EloquentOrderRepository $orderRepository
     * @param \App\Services\Calculator\EloquentDurationCalculator $durationCalculator
     * @param \App\Services\Calculator\EloquentSchedulerDateCalculator $dateCalculator
     * @param \App\Services\Contract\SortCalculator $sortCalculator
     */
    public function __construct(
        private EloquentOrderRepository $orderRepository,
        private EloquentDurationCalculator $durationCalculator,
        private EloquentSchedulerDateCalculator $dateCalculator,
        private SortCalculator $sortCalculator,
    ) {
    }


    /**
     * Summary of generate
     * @return \Illuminate\Support\Collection
     */
    public function generate(): Collection
    {

        $orders = $this->orderRepository->listOrdersToSchedule();

        $orders = $this->sortCalculator->process($orders);

        // Calculate and attach processing duration for all orders
        $ordersWithProcessingTime = $orders->map(function (Order $order) {
            return $this->durationCalculator->process($order);
        });

        /** Calculate the whole schedule */
        $startDate = Carbon::now()->addHours(1);

        $previousProductTypeId = null;

        $schedule = $ordersWithProcessingTime->map(function (Order $order) use (&$startDate, &$previousProductTypeId) {
            return $this->dateCalculator->process($order, $startDate, $previousProductTypeId);
        });

        return $schedule;
    }
}
