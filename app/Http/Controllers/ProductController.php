<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * [all description]
     * @return [type] [description]
     */
    public function all()
    {
        $product = Product::all();

        return response()->json([
            "product" => $product
        ], 200);
    }

    /**
     * [create description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'sku'   => 'required|string|max:191|unique:products',
        ]);
        $product = Product::create([
            'sku'      => $request['sku'],
        ]);
        return response()->json([
            "product" => $product
        ], 200);
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            "product" => $product
        ], 200);
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request,[
            'sku' => 'required|string|max:191|unique:products,sku,'.$product->id,
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Updated the product info'
        ], 200);
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted'
        ], 200);
    }
}
