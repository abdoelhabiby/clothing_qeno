<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Controllers\Api\Front\BaseController;

class CategoryController extends BaseController
{
    public $per_page_paginate;

    public function __construct(Request $request)
    {
        $this->per_page_paginate = (int) $request->per_page && $request->per_page  > 0 ? $request->per_page : API_PAGINATE_COUNT;
    }




    public function index(Request $request)
    {



        $per_page = $this->per_page_paginate;
        $query_append = ['per_page' => $per_page];

        $categories = Category::latest()->get();

        $categories_paginate = CategoryCollection::collection($categories);



        $response = ['categories' => $categories_paginate];

        return $this->sendResponse($response, '');
    } //--------



    // -------------------------------------------------------------
    public function productsCategory(Category $category)
    {
        $per_page = $this->per_page_paginate;

        $query_append = ['per_page' => $per_page];

        $products = $category->products()->latest()->paginate($per_page)->appends($query_append);

        $category = new CategoryCollection($category);


        $products_collection = ProductCollection::collection($products)->response()->getData(true);

        if (isset($products_collection['meta']['links'])) {
            unset($products_collection['meta']['links']);
        }


        $products_data = isset($products_collection['data']) ? $products_collection['data'] : [];
        $links = isset($products_collection['links']) ? $products_collection['links'] : [];
        $meta = isset($products_collection['meta']) ? $products_collection['meta'] : [];

        $response = [
            'category' => $category,
            'products' => $products_data,
            'links' => $links,
            'meta' => $meta
        ];


        // $response = ['category' => $category, 'products' => $products];

        return $this->sendResponse($response, '');
    }
    // -------------------------------------------------------------

    public function categoriesProducts()
    {




        $categories = Category::latest()->with(['products' => function ($product) {
            $product->limit(4);
        }])->latest()->limit(5)->get();


        $categories_products = CategoryCollection::collection($categories);


        $response = ['categories' => $categories_products];

        return $this->sendResponse($response, '');
    }
    // -------------------------------------------------------------
    // -------------------------------------------------------------
    // -------------------------------------------------------------

}
