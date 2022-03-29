<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Services\FileService;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Controllers\Api\Front\BaseController;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Resources\Api\UserCollection;

class UserController extends BaseController
{


    public function getUser(Request $request)
    {


        $result = new UserCollection($request->user());
        return $this->sendResponse($result, 'user data');
    }



    public function register(UserRequest $request)
    {


        try {

            $validated = $request->validated();

            $validated['password'] = Hash::make($validated['password']);

            if ($request->hasFile('image') && $request->image != null) {



                $folder_path = public_path('images/users');
                FileService::checkDirectoryExistsOrCreate($folder_path);

                $image = $request->file('image');
                $path = 'images/users/' . $image->hashName();
                FileService::reszeImageAndSave($image, public_path(), $path, 50, 50);
                $validated['image'] = $path;
            }



            $user = User::create($validated);

            $result = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken('halamadrid')->plainTextToken
            ];

            return $this->sendResponse($result, 'success register');
        } catch (\Throwable $th) {

            return $this->sendError('failed tray again later');
        }
    } //--------




    // -------------------------------------------------------------

    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ]
        );


        if(auth()->attempt($validated)){

            $user = auth()->user();

            $user->tokens()->delete();

            $result = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken('halamadrid')->plainTextToken
            ];

            return $this->sendResponse($result, 'success login');
        }


        return $this->sendError('The given data was invalid');

    }

    // -------------------------------------------------------------
    // -------------------------------------------------------------
    // -------------------------------------------------------------

}
