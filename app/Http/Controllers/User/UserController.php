<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscribers;

use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    function create(Request $request){
        //Validate Inputs
      
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:5|max:30',
            'cpassword'=>'required|min:5|max:30|same:password'
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();
        $last_id = $user->id;
        
        if($request->hasFile('upload_image'))
         {
            $image = $request->file('upload_image');
            $teaser_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $teaser_image);
            $sub = new Subscribers();
            $sub->user_id = $last_id;
            $sub->image_path = $teaser_image;
            $save = $sub->save();

          }
        
        



        if( $last_id ){
            return redirect()->back()->with('success','You are now registered successfully');
        }else{
            return redirect()->back()->with('fail','Something went wrong, failed to register');
        }
  }

  function check(Request $request){
      //Validate inputs
      $request->validate([
         'email'=>'required|email|exists:users,email',
         'password'=>'required|min:5|max:30'
      ],[
          'email.exists'=>'This email is not exists on users table'
      ]);

      $creds = $request->only('email','password');
      if( Auth::guard('web')->attempt($creds) ){
          return redirect()->route('user.home');
      }else{
          return redirect()->route('user.login')->with('fail','Incorrect credentials');
      }
  }

  function logout(){
      Auth::guard('web')->logout();
      return redirect('/');
  }
}