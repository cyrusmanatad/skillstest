<?php

namespace App\Http\Datatable;

use App\Libraries\Datatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class ProductDatatable
{
    private function deleteBladeTemplateAction(Request $request, $route, $productId) {
        // Render the Blade components manually before returning them
        $deleteButtonHtml = Blade::render('
            <x-heroicon-o-trash x-on:click.prevent="$dispatch(\'open-modal\', \'confirm-user-deletion\')" class="h-5 w-5" style="color: red; cursor: pointer" />
        ', ['errors' => $request->session()->get('errors')]);

        $modalHtml = Blade::render('
            <x-modal name="confirm-user-deletion"  focusable>
                <form method="post" action="{{ route($route, $id) }}" class="p-6">
                    @csrf
                    @method(\'delete\')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __("Are you sure you want to delete the product?") }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Once the product is deleted, all of its resources and data will be permanently deleted.") }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch(\'close-modal\', \'confirm-user-deletion\')">
                            {{ __("Cancel") }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __("Delete Product") }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        ', [
            'errors' => $request->session()->get('errors'),
            'route' => $route,
            'id' => $productId
        ]);

        // Combine the delete button and modal HTML to return as a string
        return $deleteButtonHtml . $modalHtml;
    }

    private function editBladeTemplateAction(Request $request, $route, $productId) {
        // Render the Blade components manually before returning them
        return Blade::render('
            <x-heroicon-o-pencil-square x-on:click.prevent="window.location.href = \'' . route($route, $productId) . '\'" class="h-5 w-5" style="cursor: pointer" />
        ', [
            'errors' => $request->session()->get('errors'),
            'route' => $route,
            'id' => $productId
        ]);
    }

    public function customer(Request $request)
    {
        $columns = [
            [ 'db' => 'sku_code', 'dt' => 0 ],
            [ 'db' => 'title', 'dt' => 1 ],
            [ 'db' => 'description', 'dt' => 2 ],
            [ 'db' => 'price', 'dt' => 3 ],
            [ 'db' => 'price_adjustment', 'dt' => 4 ],
            [ 'db' => 'created_at', 'dt' => 5 ],
            [ 'db' => 'id', 'dt' => 6, 'formatter' => function($d) use($request) {
                return $this->editBladeTemplateAction($request, 'product.edit', $d) . $this->deleteBladeTemplateAction($request, 'product.destroy', $d);
            } ]
        ];

        // return json
        return response()->json(
            Datatable::simple( $_POST, [
                'user' => env('DB_USERNAME'),
                'pass' => env('DB_PASSWORD'),
                'db'   => env('DB_DATABASE'),
                'host' => env('DB_HOST'),
                'charset' => 'utf8mb4'
            ], 'products', 'id', $columns, $request->user()->id )
        );
    }

    public function admin(Request $request)
    {
        $columns = [
            [ 'db' => 'sku_code', 'dt' => 0 ],
            [ 'db' => 'title', 'dt' => 1 ],
            [ 'db' => 'description', 'dt' => 2 ],
            [ 'db' => 'price', 'dt' => 3 ],
            [ 'db' => 'price_adjustment', 'dt' => 4 ],
            [ 'db' => 'created_at', 'dt' => 5 ],
            [ 'db' => 'id', 'dt' => 6, 'formatter' => function($d, $row) use($request) {

                if($request->user()->id == $row['user_id']) {
                    return "<div class='flex'>
                        " . $this->editBladeTemplateAction($request, 'admin.product.edit', $d) . "
                        " . $this->deleteBladeTemplateAction($request, 'admin.product.destroy', $d) . "
                    </div>";
                    // return $this->editBladeTemplateAction($request, 'admin.product.edit', $d) . $this->deleteBladeTemplateAction($request, 'admin.product.destroy', $d);
                }

                return "-";
            } ],
            [ 'db' => 'user_id', 'dt' => null ]
        ];

        $productOwner = $request->post('productOwner');

        // return json
        return response()->json(
            Datatable::simple( $_POST, [
                'user' => env('DB_USERNAME'),
                'pass' => env('DB_PASSWORD'),
                'db'   => env('DB_DATABASE'),
                'host' => env('DB_HOST'),
                'charset' => 'utf8mb4'
            ], 'products', 'id', $columns, $productOwner )
        );
    }
}
