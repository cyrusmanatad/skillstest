<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Product') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure to fill-out all fields.') }}
        </p>
    </header>

    <form method="post" action="{{ route('admin.product.create') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="title" :value="__('Product Name')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="new-title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" autocomplete="new-description" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="sku_code" :value="__('SKU Code')" />
            <x-text-input id="sku_code" name="sku_code" type="text" class="mt-1 block w-full" autocomplete="new-sku_code" />
            <x-input-error :messages="$errors->get('sku_code')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" autocomplete="new-price" />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="price_adjustment" :value="__('Price Adjustment')" />
            <x-text-input id="price_adjustment" name="price_adjustment" type="text" class="mt-1 block w-full" autocomplete="new-price_adjustment" />
            <x-input-error :messages="$errors->get('price_adjustment')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <x-action-link :href="route('admin.product.list')">
                {{ __('Cancel') }}
            </x-action-link>
        </div>
    </form>
</section>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(() => {
        console.log('Document ready');
    })
</script>