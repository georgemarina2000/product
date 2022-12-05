<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return (Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric',
            'brand' => 'required|string'
        ]);

        $product = Product::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'brand' => $request->brand

            ]
        );

        return response()->json('success store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($product = Product::find($id)) {
            return response()->json($product);
        }
        return response()->json("no data");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($product = Product::find($id)) {
            $request->validate([
                'name' => 'required|string|min:3',
                'description' => 'required|string|min:10',
                'price' => 'required|numeric',
                'brand' => 'required|string'
            ]);

            $product->update(
                [
                    $product->name = $request->name,
                    $product->description = $request->description,
                    $product->price = $request->price,
                    $product->brand = $request->brand

                ]
            );

            return response()->json('success update');
        }
        return response()->json("no data");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($product = Product::find($id)) {
            $product->delete();
            return response()->json("success delete");
        }
        return response()->json("no data");
    }
}
