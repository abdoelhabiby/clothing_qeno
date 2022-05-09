<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $rows = Category::orderBy('id', 'desc')->paginate(DASHBOARD_PAGINATE_COUNT);

        return view('dashboard.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {




        try {

            $validated = $request->validated();
            $validated['is_active'] = $request->has('is_active') ? true : false; //get active


            //-------------uploade image if found-----------

            if ($request->hasFile('image') && $request->image != null) {

                $image = $request->image;
                $folder = 'images/categories';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);
            }

            Category::create($validated);
            sweetAlertFlush('success', 'success', 'Data has been stored successfully!');


            return redirect()->route('dashboard.categories.index');
        } catch (\Throwable $th) {


            return catchErro('dashboard.users.index', $th);
        }
    } //end method



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $row = $category;
        return view('dashboard.categories.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {



        try {

            $validated = $request->validated();
            $validated['is_active'] = $request->has('is_active') ? true : false; //get active


            //-------------uploade image if found-----------

            if ($request->hasFile('image') && $request->image != null) {

                $image = $request->image;
                $folder = 'images/categories';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);


                if ($category->image) {
                    FileService::deleteFile(public_path($category->image));
                }
            }

            $category->update($validated);
            sweetAlertFlush('success', 'success', 'Data has been stored successfully!');

            return redirect()->route('dashboard.categories.index');
        } catch (\Throwable $th) {


            return catchErro('dashboard.users.index', $th);
        }
    } //----end of method

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {


        try {

            if ($category->image) {
                FileService::deleteFile(public_path($category->image));
            }

            $category->delete();
            sweetAlertFlush('success', 'success', 'Data has been deleted successfully!');

            return redirect()->route('dashboard.categories.index');
        } catch (\Throwable $th) {

            return catchErro('dashboard.users.index', $th);
        }
    } //----end of method
}
