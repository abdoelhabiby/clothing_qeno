<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Product::orderBy('id', 'desc')->paginate(DASHBOARD_PAGINATE_COUNT);

        return view('dashboard.products.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select(['id','name'])->get();

        return view('dashboard.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validated();
            $validated['is_active'] = $request->has('is_active') ? true : false; //get active


            //-------------uploade image if found-----------

            if ($request->hasFile('image') && $request->image != null) {

                $folder_path = public_path('images/products');

                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/products/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path);
                $validated['image'] = $path;
            }

            $categories = [];

            if($request->categories){
                $categories = $request->categories ;
                unset($validated['categories']);

            }

            $validated['vendor_id'] = admin()->id;

            $product = Product::create($validated);

            $product->categories()->sync($categories);


            DB::commit();

            return redirect()->route('dashboard.products.index')->with('success_message', 'succes create category');
        } catch (\Throwable $th) {

            DB::rollback();

            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }


    }//end method



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
       $row = $product;
       $categories = Category::select(['id','name'])->get();


       return view('dashboard.products.edit',compact(['row','categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validated();
            $validated['is_active'] = $request->has('is_active') ? true : false; //get active


            //-------------uploade image if found-----------

            if ($request->hasFile('image') && $request->image != null) {

                $folder_path = public_path('images/products');

                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/products/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path);
                $validated['image'] = $path;

                if($product->image){
                    FileService::deleteFile(public_path($product->image));
                }

            }

            $categories = [];

            if($request->categories){
                $categories = $request->categories ;
                unset($validated['categories']);

            }

            $validated['vendor_id'] = admin()->id;

            $product->update($validated);

            $product->categories()->sync($categories);


            DB::commit();

            return redirect()->route('dashboard.products.index')->with('success_message', 'succes update category');

        } catch (\Throwable $th) {

            DB::rollback();


            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        try{

            if($product->image){
                FileService::deleteFile(public_path($product->image));
            }

         $product->delete();

            return redirect()->route('dashboard.products.index')->with('success_message', 'succes delete category');
        } catch (\Throwable $th) {


            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }
    }//-
}
