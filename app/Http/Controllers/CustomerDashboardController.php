<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    }

    public function products(Request $request): View
    {
        return view('customer.index', [
            'page' => 'default',
            'user' => $request->user(),
        ]);
    }

    public function formView(Request $request): View
    {
        return view('customer.index', [
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

        return redirect()->route('product.list')->with('success', 'Product created successfully.');
    }

    public function edit(FormRequest $request, $productId): View
    {
        return view('customer.index', [
            'page' => 'edit',
            'user' => $request->user(),
            'product' => Product::find($productId),
        ]);
    }

    public function update(ProductUpdateRequest $request, $productId)
    {
        // validate post request
        $validatedData = $request->validated();

        Product::where([
            'id' => $productId,
            'user_id' => $request->user()->id,
        ])->update($validatedData);

        return redirect()->route('product.list')->with('success', 'Product updated successfully.');
    }

    public function destroy(FormRequest $request, $productId)
    {

        Product::where([
            'id' => $productId,
            'user_id' => $request->user()->id,
        ])->delete();

        return redirect()->route('product.list')->with('success', 'Product delete successfully.');
    }
}
