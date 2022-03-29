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
        $this->per_page_paginate = (int) $request->per_page && $request->per_page  > 0 ? $request->per_page : 5;
    }




    public function index(Request $request)
    {



        $per_page = $this->per_page_paginate;
        $query_append = ['per_page' => $per_page];

        $categories = Category::latest()->paginate($per_page)->appends($query_append);

        $categories_paginate = CategoryCollection::collection($categories)->response()->getData(true);

        if (isset($categories_paginate['meta']['links'])) {
            unset($categories_paginate['meta']['links']);
        }

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


        $products = ProductCollection::collection($products)->response()->getData(true);

        if (isset($products['meta']['links'])) {
            unset($products['meta']['links']);
        }

        $response = ['category' => $category, 'products' => $products];

        return $this->sendResponse($response, '');
    }
    // -------------------------------------------------------------
    // -------------------------------------------------------------
    // -------------------------------------------------------------
    // -------------------------------------------------------------

}
