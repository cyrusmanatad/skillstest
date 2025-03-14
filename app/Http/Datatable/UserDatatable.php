<?php

namespace App\Http\Datatable;

use App\Libraries\Datatable;
use Illuminate\Http\Request;

class UserDatatable
{
    public function datatable(Request $request)
    {
        $columns = [
            [ 'db' => 'name', 'dt' => 0 ],
            [ 'db' => 'email', 'dt' => 1 ],
            [ 'db' => 'role', 'dt' => 2 ],
            [ 'db' => 'created_at', 'dt' => 3 ],
            [ 'db' => 'id', 'dt' => 4, 'formatter' => function($d) {
                return '<a href="' . route('user.product.list', $d) . '" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">View Products</a>';
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
            ], 'users', 'id', $columns )
        );
    }
}
