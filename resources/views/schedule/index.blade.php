<x-layout>
    <x-card class="p-10 max-w-4xl mx-auto mt-24">
        <header class="text-center">

            <h2 class="text-2xl font-bold uppercase mb-1">Scheduling</h2>
        </header>

        @unless (count($schedule) > 0)
            <p>No orders to schedule</p>
        @else
            <ol class="relative border-s border-gray-200 dark:border-gray-700">

                @foreach ($schedule as $scheduledOrder)
                    <x-schedule-card :order="$scheduledOrder" />
                @endforeach

            </ol>
        @endunless

    </x-card>

</x-layout>
