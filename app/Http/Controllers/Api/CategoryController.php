<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CategoryCollection;

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

        $categories_paginate = CategoryCollection::collection(Category::paginate($per_page))->response()->getData(true);

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

        $products = $category->products()->paginate($per_page);

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
