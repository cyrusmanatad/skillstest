<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    
                    @switch($page)
                        @case('form')
                            @include('customer.partials.create-product-form')
                            @break
                        @case('edit')
                            @include('customer.partials.edit-product-form')
                            @break
                        @default

                            <a href="{{ route('product.form') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Create Product') }}
                            </a>

                            @include('customer.partials.table-products')
                    @endswitch

                </div>
            </div>
        </div>
    </div>
</x-app-layout>