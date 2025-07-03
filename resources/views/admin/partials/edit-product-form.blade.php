<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Product') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure to fill-out all fields.') }}
        </p>
    </header>

    <form method="post" action="{{ route('admin.product.update', $product->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="create_product_title" :value="__('Product Name')" />
            <x-text-input id="create_product_title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $product->title)" autocomplete="new-title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="create_product_body" :value="__('Description')" />
            <x-text-input id="create_product_body" name="body" type="text" class="mt-1 block w-full" :value="old('body', $product->body)" autocomplete="new-body" />
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <div>
            {{-- <x-input-label for="create_product_user_id" :value="__('Customer Tagging')" />
            <x-text-input id="create_product_user_id" name="user_id" type="text" class="mt-1 block w-full" :value="old('user_id', $product->user_id)" autocomplete="new-body" /> --}}
            <x-select-option 
                name="user_id" 
                label="{{ __('Customer Tagging') }}" 
                :options="$mappedUsers" 
                :selected="old('user_id', $product->user_id)" 
            />
            {{-- <x-input-error :messages="$errors->get('body')" class="mt-2" /> --}}

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
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