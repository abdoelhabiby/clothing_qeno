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

        $rows = Category::orderBy('id', 'desc')->paginate(DASHBOARD_PAGINATE_COUNT);

        return view('dashboard.categories.index', compact('rows'));
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

                $folder_path = public_path('images/categories');

                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/categories/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path);
                $validated['image'] = $path;
            }

            Category::create($validated);

            return redirect()->route('dashboard.categories.index')->with('success_message', 'succes create category');
        } catch (\Throwable $th) {


            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }


    }//end method



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

                $folder_path = public_path('images/categories');
                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/categories/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path);
                $validated['image'] = $path;


                if($category->image){
                    FileService::deleteFile(public_path($category->image));
                }

            }

            $category->update($validated);

            return redirect()->route('dashboard.categories.index')->with('success_message', 'succes update category');
        } catch (\Throwable $th) {


            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }
    }//----end of method

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {


        try{

            if($category->image){
                FileService::deleteFile(public_path($category->image));
            }

         $category->delete();

            return redirect()->route('dashboard.categories.index')->with('success_message', 'succes delete category');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error_message', 'some erros happend tray again');
        }
    }//----end of method
}
