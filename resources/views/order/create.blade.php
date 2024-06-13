<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">

            <h2 class="text-2xl font-bold uppercase mb-1">Create order</h2>
        </header>

        <form action="/orders" method="POST">
            @csrf

            <div class="mb-6">
                <label for="customer_id" class="inline-block text-lg mb-2"></label>
                <select class="border border-gray-200 rounded p-2 w-full" name="customer_id">
                    <option value="">Select a customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $customer->id) ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>

                @error('customer_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="product" class="inline-block text-lg mb-2"></label>
                <select class="border border-gray-200 rounded p-2 w-full" name="product">
                    <option value="">Select a product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product', $product->id) ? 'selected' : '' }}>
                            {{ $product->name }}</option>
                    @endforeach
                </select>

                @error('product')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div class="mb-6">
                <label for="amount" class="inline-block text-lg mb-2">Amount</label>
                <input type="number" class="border border-gray-200 rounded p-2 w-full" name="amount"
                    placeholder="1000" value="{{ old('amount') }}" />

                @error('amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="need_by" class="inline-block text-lg mb-2">Job Location</label>
                <input type="date" class="border border-gray-200 rounded p-2 w-full" name="need_by"
                    placeholder="20024-05-01" value="{{ old('need_by') }}" />

                @error('need_by')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    submit
                </button>

                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>
