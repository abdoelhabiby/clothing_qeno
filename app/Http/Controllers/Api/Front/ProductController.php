<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;

class ProductController extends BaseController
{


    public function index(Request $request)
    {



         $per_page =(int) $request->per_page && $request->per_page  > 0 ? $request->per_page : 5;

         $query_append = ['per_page' => $per_page];

         $products = Product::latest()->paginate($per_page)->appends($query_append);

         $products_collection = ProductCollection::collection($products)->response()->getData(true);

          if(isset($products_collection['meta']['links'])){
              unset($products_collection['meta']['links']);
          }

        $response = ['products' => $products_collection];

        return $this->sendResponse($response,'');


    }

}
