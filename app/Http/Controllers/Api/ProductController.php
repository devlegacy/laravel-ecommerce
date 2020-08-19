<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('upload.image')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Filter by category
        // ?is_active=true&paginate=25&category=1
        $paginate = (int) request()->input('paginate', 25);
        $isActive = request()->input('is_active', 'all');

        if ($isActive === 'all') {
            $products = Product::paginate($paginate);
        } else {
            $isActive = $isActive === 'true';
            $products = Product::where('is_active', $isActive)->paginate($paginate);
        }

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->input());

        return response(['data' => new ProductResource($product)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response(['data' => new ProductResource($product)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->is_active = false;
        $product->save();
        // $product->destroy();

        response(null, Response::HTTP_NO_CONTENT);
    }
}
