<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Services\FileService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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
        $categories = Category::select(['id', 'name'])->get();

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    // --------main--------------------------------------
    public function store(ProductRequest $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validated();
            $validated['is_active'] = $request->has('is_active') ? true : false; //get active


            //-------------uploade image if found-----------

            if ($request->hasFile('image') && $request->image != null) {

                $image = $request->image;
                $folder = 'images/products';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);
            }

            $categories = [];

            if ($request->categories && count($request->categories) > 0) {
                $categories = $request->categories;
                unset($validated['categories']);
            }


            $validated['vendor_id'] = admin()->id;

            $product = Product::create($validated);

            $product->categories()->sync($categories);


            DB::commit();
            sweetAlertFlush( 'success', 'success' , 'Data has been saved successfully!');

            return redirect()->route('dashboard.products.index');
        } catch (\Throwable $th) {

            DB::rollback();


            return catchErro('dashboard.users.index', $th);
        }
    } //end method


    // --------main--------------------------------------

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $row = $product;
        $categories = Category::select(['id', 'name'])->get();


        return view('dashboard.products.edit', compact(['row', 'categories']));
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

                $image = $request->image;
                $folder = 'images/products';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);


                if ($product->image) {
                    FileService::deleteFile(public_path($product->image));
                }
            }

            $categories = [];

            if ($request->categories) {
                $categories = $request->categories;
                unset($validated['categories']);
            }

            $validated['vendor_id'] = admin()->id;

            $product->update($validated);

            $product->categories()->sync($categories);


            DB::commit();
            sweetAlertFlush( 'success', 'success' , 'Data has been saved successfully!');

            return redirect()->route('dashboard.products.index');
        } catch (\Throwable $th) {

            DB::rollback();


            return catchErro('dashboard.users.index', $th);
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

        try {

            if ($product->image) {
                FileService::deleteFile(public_path($product->image));
            }

            $product->delete();
            sweetAlertFlush( 'success', 'success' , 'Data has been deleted successfully!');

            return redirect()->route('dashboard.products.index');
        } catch (\Throwable $th) {


            return catchErro('dashboard.users.index', $th);
        }
    } //-
}
