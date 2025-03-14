<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Manage Products') }}
        </h2>

        @if(session('success'))
            <p class="mt-1 text-gray-600 text-green-600 text-sm text-xl">
                {{ session('success') }}
            </p>
        @endif
    </header>

    <table id="dataTable" class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase
                uppercase tracking-wider">
                {{ __('Product Name') }}
                </th>
                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase
                uppercase tracking-wider">
                {{ __('Description') }}
                </th>
                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase
                uppercase tracking-wider">
                {{ __('Created') }}
                </th>
                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase
                uppercase tracking-wider">
                {{ __('Action') }}
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{-- dynamic --}}
        </tbody>
    </table>

</section>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(() => {
        const _datatable = new DataTable('#dataTable', {
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dt.admin.products') }}",
                type: 'post',
                data: (d) => {
                    d.division = 'test'
                }
            }
        });
    })
</script>