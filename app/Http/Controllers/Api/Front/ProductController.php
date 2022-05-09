<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;

class ProductController extends BaseController
{


    public function index(Request $request)
    {



         $per_page =(int) $request->per_page && $request->per_page  > 0 ? $request->per_page : API_PAGINATE_COUNT;
         $query_append = ['per_page' => $per_page];
         $products = Product::latest()->paginate($per_page)->appends($query_append);

         $products_collection = ProductCollection::collection($products)->response()->getData(true);


          if(isset($products_collection['meta']['links'])){
              unset($products_collection['meta']['links']);
          }

          $products_data = isset($products_collection['data']) ? $products_collection['data'] : [];
          $links = isset($products_collection['links']) ? $products_collection['links'] : [];
          $meta = isset($products_collection['meta']) ? $products_collection['meta'] : [];

         $response = [
             'products' => $products_data,
             'links' => $links,
             'meta' => $meta
            ];

        return $this->sendResponse($response,'');


    }





    // -----------------------------------------------

}
