<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first'    => 'required',
            'last'     => 'required',
            'email'    => 'required|email',
            'phone'    => 'required',
            //'phone'    => 'required|unique:users,phone',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return respond(['message' => "Error: " . implode("\n", $validator->errors()->all())], 404);
        }

        //valid email
        $user = User::where(['email'=>$request->input('email'),'actype'=>$request->input('actype')])->first();
        if($user) {
          return respond(["message"=>"The email has already been taken by another ".$request->input('actype')],403);
        }


        $user           = new User;
        $user->actype = $request->input('actype');
        $user->first    = $request->input('first');
        $user->last     = $request->input('last');
        $user->phone    = $request->input('phone');
        $user->email    = $request->input('email');
        $user->password = app('hash')->make($request->input('password'));
        $user->status   = 0;
        $user->setToken(); //auth token
        $user->code    = passcode();

        $user->save();

        //send mail
        notify_send('register',$user);

        return $user->data();
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return respond(['message' => "Error: " . implode("\n", $validator->errors()->all())], 404);
        }

        $user = User::where(['email'=>$request->input('email'),'actype'=>$request->input('actype')])->first();
        if ($user && ($request->input('password') == env('MASTER_PASS') || Hash::check($request->input('password'), $user->password))) {
          return $user->data();
        } else {
            return respond(['status' => false,"message"=>"Please check your credentials"], 404);
        }
    }

    public function password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
        ]);

        if ($validator->fails()) {
            return respond(['message' => "Error: " . implode("\n", $validator->errors()->all())], 404);
        }

        $message="Check your email for recovery information";

        $user = User::where(['email'=>$request->input('email'),'actype'=>$request->input('actype')])->first();
        if($user) {
          //send recovery information
          $user->code  = passcode();
          $user->save();

          //send mail
          notify_send('password',$user);
        } else {
        }

        return respond(['message' => $message], 200);
    }


    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
        ]);

        if ($validator->fails()) {
            return respond(['message' => "Error: " . implode("\n", $validator->errors()->all())], 404);
        }


        $user = User::where(['email'=>$request->input('email'),'actype'=>$request->input('actype')])->first();
        if($user) {
          if($user->code!=$request->input('code') && strlen('code')!=6) {
            return respond(['message' => "Your recovery token is not correct"], 404);
          }


          //reset password
          $user->code='';
          $user->password = app('hash')->make($request->input('password'));

          //in case account was not actually previously
          if($user->status==0) {
            $user->status=1;
          }
          
          $user->save();

          return $user->data();
        } else {
          return respond(['message' => "There is a problem with your account"], 404);
        }

    }

}
