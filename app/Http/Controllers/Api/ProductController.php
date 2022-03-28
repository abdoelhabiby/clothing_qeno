<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;

class ProductController extends BaseController
{


    public function index(Request $request)
    {



        $per_page =(int) $request->per_page && $request->per_page  > 0 ? $request->per_page : 5;

          $products = ProductCollection::collection(Product::paginate($per_page))->response()->getData(true);

          if(isset($products['meta']['links'])){
              unset($products['meta']['links']);
          }

        $response = ['products' => $products];

        return $this->sendResponse($response,'');


    }

}
