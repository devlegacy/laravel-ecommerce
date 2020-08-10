<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = (int) request()->input('paginate', 25);
        $isActive = request()->input('is_active', 'all');

        if ($isActive === 'all') {
            $categories = Category::paginate($paginate)->appends(request()->input());
        } else {
            $isActive = $isActive === 'true' ? true : false;
            $categories = Category::where('is_active', $isActive)->paginate($paginate)->appends(request()->input());
        }

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        return response(['data' => new CategoryResource($category)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category             $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category             $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return response(['data' => new CategoryResource($category)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category             $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->is_active = false;
        $category->save();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
