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

    public function __construct()
    {


        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:update_users')->only(['edit', 'update']);
        // $this->middleware('permission:delete_users')->only('destroy');
    }




    //------------------------shoew all uesrs------------------
    public function index()
    {
        return view('dashboard.users.index');
    }

    //-----------------------------------------------


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

                $image = $request->image;
                $folder = 'images/users';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);

            }else{

                $validated['image'] = 'images/user_default.png';
            }

            User::create($validated);

            sweetAlertFlush( 'success', 'success' , 'Data has been saved successfully!');

            return redirect()->route('dashboard.users.index');
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

                $image = $request->image;
                $folder = 'images/users';
                $image_name = $image->hashName();
                $validated['image'] = FileService::saveImage($image, public_path(), $folder, $image_name);

                FileService::deleteFile(public_path($user->image));

            }



            $user->update($validated);

            sweetAlertFlush( 'success', 'success' , 'Data has been saved successfully!');

            return redirect()->route('dashboard.users.index');
        } catch (\Throwable $th) {
            return catchErro('dashboard.users.index', $th);
        }
    }



    //----------------delete user ------------------


    // public function destroy(User $user)
    // {

    //     try {



    //         if($user->image){
    //             FileService::deleteFile(public_path($user->image));
    //         }

    //         $user->delete();

    //         return redirect()->route('dashboard.users.index')->with('success_message', 'succes delete');
    //     } catch (\Throwable $th) {
    //         return catchErro('dashboard.users.index', $th);
    //     }
    // }

}
