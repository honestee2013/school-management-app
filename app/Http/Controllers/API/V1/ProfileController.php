<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Models\Honestee\VueCodeGen\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Return the user data
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $response = [
            'success' => true,
            'data'    => auth('api')->user(),
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the profile by users
     *
     * @param  \App\Http\Requests\Users\ProfileUpdateRequest  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {

        $user = auth('api')->user();

        $user->update([
            'name' => $request['name'], 
            'email' => $request['email'],
            'gender' => $request['gender'],
            'phone' => $request['phone']
        ]);

        $userImages = $user->getMedia("user-images");
        if( count($userImages) ) {
            for($i=0; $i < count($userImages); $i++){
                if($userImages[$i]->name == "profilePicture" && !empty($request['profilePicture'])){
                    $userImages[$i]->delete();
                    $user->addMedia($request['profilePicture'])->usingName('profilePicture')->toMediaCollection('user-images');
                } 
            }
        } else {
            if(!empty(['profilePicture']))
                $user->addMedia($request['profilePicture'])->usingName('profilePicture')->toMediaCollection('user-images');
        }
        

        $response = [
            'success' => true,
            'data'    => $user,
            'message' => 'Profile has been updated',
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\ChangePasswordRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        User::find(auth('api')->user()->id)->update(['password' => Hash::make($request->new_password)]);

        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Password Has been updated',
        ];
        return response()->json($response, 200);
    }




/** 
    * success response method.
     *
     * @param    $result
     * @param    $message
     *
     * @return    \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success'        => true,
            'message'        => $message,
            'data'           => $result,
        ];
        return response()->json($response, 200);
    }







}
