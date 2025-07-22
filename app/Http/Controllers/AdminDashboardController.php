<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminProductUpdateRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function products(Request $request): View
    {
        return view('admin.index', [
            'page' => 'default',
            'user' => $request->user(),
        ]);
    }

    public function formView(Request $request): View
    {
        return view('admin.index', [
            'page' => 'form',
            'user' => $request->user(),
        ]);
    }

    public function create(ProductCreateRequest $request)
    {
        // validate post request
        $validatedData = $request->validated();

        $validatedData['user_id'] = $request->user()->id;

        Product::create($validatedData);

        return redirect()->route('admin.product.list')->with('success', 'Product created successfully.');
    }

    public function edit(FormRequest $request, $productId): View
    {
        $users = User::all();

        // filter user for select option
        $mappedUsers = $users->filter(function ($user) use ($request) {
            return $user->id !== $request->user()->id;
        });

        // map user_id and name for select option
        $mappedUsers = $mappedUsers->map(fn ($user) => [ 'key' => $user->id, 'text' => $user->name ]);

        return view('admin.index', [
            'page' => 'edit',   
            'user' => $request->user(),
            'product' => Product::find($productId),
            'mappedUsers' => $mappedUsers,
        ]);
    }

    public function update(AdminProductUpdateRequest $request, $productId)
    {
        // validate post request
        $validatedData = $request->validated();

        Product::where([
            'id' => $productId,
            'user_id' => $request->user()->id,
        ])->update($validatedData);

        return redirect()->route('admin.product.list')->with('success', 'Product updated successfully.');
    }

    public function destroy(FormRequest $request, $productId)
    {

        Product::where([
            'id' => $productId,
            'user_id' => $request->user()->id,
        ])->delete();

        return redirect()->route('admin.product.list')->with('success', 'Product delete successfully.');
    }

    public function users(Request $request): View
    {
        return view('admin.index', [
            'page' => 'users',
            'user' => $request->user(),
        ]);
    }

    public function userProducts(Request $request, $userId): View
    {
        // find user products
        // $products = Product::where('user_id', $userId)->get();

        return view('admin.index', [
            'page' => 'products',
            'user' => $request->user(),
            'productsOwner' => $userId,
        ]);
    }
}
