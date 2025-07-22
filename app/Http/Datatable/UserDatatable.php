<?php

namespace App\Http\Datatable;

use App\Models\User;
use Illuminate\Http\Request;

class UserDatatable
{
    public function datatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $search = $request->get('search')['value'] ?? '';
        
        // Build query
        $query = User::query();
        
        // Apply search
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Get total records
        $totalRecords = User::count();
        $filteredRecords = $query->count();
        
        // Apply ordering
        if ($request->has('order')) {
            $orderColumn = $request->get('order')[0]['column'];
            $orderDir = $request->get('order')[0]['dir'];
            
            $columns = ['name', 'email', 'created_at', 'id'];
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            }
        }
        
        // Apply pagination
        $users = $query->skip($start)->take($length)->get();
        
        // Format data
        $data = $users->map(fn($user) => [
                $user->name,
                $user->email,
                $user->getRoles()->map(fn($role) => $role->name) ?? 'N/A',
                $user->created_at->format('j M Y h:i a'),
                "<a href='" . route('user.product.list', $user->id) . "' class='inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'>View Products</a>"
            ]
        );
        
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
