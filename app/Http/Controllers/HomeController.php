<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('pages.home')-> with('user', $user);
    }

    public function addProfilePic(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        if($request->hasFile('profile_image')){
            //get file name with extension
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            //get only file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get only extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            //get the complete file to be stored
            $fileNameToStore = $fileName."_".time().".".$extension;
            //upload file
            $path = $request->file('profile_image')->storeAs('public/profile_image', $fileNameToStore);
            // //Delete Previous file
            // unlink(public_path('storage/profile_image/'.$user->cover_image));
        }
        if($request->hasFile('profile_image')){
            $user->profile_image = $fileNameToStore;
        }
        $user->save();
        return redirect('/home')->with ('success', 'Profile Pic Updated');


    }
}
