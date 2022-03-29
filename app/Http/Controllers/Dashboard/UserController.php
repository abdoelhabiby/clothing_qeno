<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\UserRequest;

class UserController extends Controller
{



    //------------------------shoew all uesrs------------------
    public function index()
    {
        $rows = User::paginate(DASHBOARD_PAGINATE_COUNT);
        return view('dashboard.users.index', compact('rows'));
    }

    //------------------------show all uesrs------------------


    //------------------------create uesr------------------

    public function create()
    {
        return view('dashboard.users.create');
    }
    //------------------------create uesrs------------------

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {



        try {

            $validated = $request->validated();

            $validated['password'] = Hash::make($validated['password']);

            if ($request->hasFile('image') && $request->image != null) {


                $folder_path = public_path('images/users');
                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/users/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path,50,50);
                $validated['image'] = $path;




            }

            User::create($validated);

            return redirect()->route('dashboard.users.index')->with(['success_message' => "success create"]);
        } catch (\Throwable $th) {
            return catchErro('dashboard.users.index', $th);
        }
    }




    //-----------------edit user ------------------
    public function edit(User $user)
    {
        $row = $user;
        return view('dashboard.users.edit', compact('row'));
    }
    //-----------------edit user ------------------


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {



        try {

            $validated = $request->validated();

            if ($request->password && $request->password != '' && !empty(trim($request->password))) {

                $validated["password"] = bcrypt($request->password);
            } else {

                unset($validated['password']);
            }

            if ($request->hasFile('image') && $request->image != null) {

                $folder_path = public_path('images/users');
                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/users/' . $image->hashName();

                FileService::reszeImageAndSave($image, public_path(), $path);
                $validated['image'] = $path;
                FileService::deleteFile(public_path($user->image));



                // ---------------------------------


            }



            $user->update($validated);


            return redirect()->route('dashboard.users.index')->with(['success_message' => "success update"]);
        } catch (\Throwable $th) {
            return catchErro('dashboard.users.index', $th);
        }
    }



    //----------------delete user ------------------


    public function destroy(User $user)
    {

        try {



            if($user->image){
                FileService::deleteFile(public_path($user->image));
            }

            $user->delete();

            return redirect()->route('dashboard.users.index')->with('success_message', 'succes delete');
        } catch (\Throwable $th) {
            return catchErro('dashboard.users.index', $th);
        }
    }
}
