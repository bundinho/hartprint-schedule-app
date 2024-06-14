@props(['order'])
@if (isset($order->changeover_start_date))
    <li class="mb-10 ms-4">
        <div
            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
        </div>
        <time
            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $order->changeover_start_date }}</time>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-500">Produt type switch setup</h3>
    </li>
@endif

<li class="mb-10 ms-4">
    <div
        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
    </div>
    <time
        class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $order->factoring_start_date }}</time>
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-500">Order #{{ $order->id }} - Product type:
        {{ $order->products[0]?->type->name }} (needed by {{ $order->need_by }})</h3>
    <p class="my-1 text-base font-normal text-gray-500 dark:text-gray-400">
        Total number of products to process: {{ $order->total_products }}
    </p>
    <p class="my-1 text-base font-normal text-gray-500 dark:text-gray-400">
        Duration of : {{ Number::format($order->factoring_duration, 2) }} hours
    </p>
    <h4 class="text-md my-1 font-normal text-gray-500 dark:text-gray-400">Details</h4>
    <ol>
        @foreach ($order->products as $product)
            <li class="mx-4 my-1">
                {{ $product->name }}: {{ $product->orderItem->amount }}
            </li>
        @endforeach
    </ol>
    <time class="my-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Esimated production end
        time:{{ $order->factoring_end_date }}</time>
</li>
