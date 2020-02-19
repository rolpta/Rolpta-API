<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function sync(Request $request)
    {

      /*
      if($request->input('lat')!='' && $request->user->position->locked==0) {
        $request->user->position->lat=$request->input('lat');
        $request->user->position->lng=$request->input('lng');
        $request->user->position->city=$request->input('city');
        $request->user->position->state=$request->input('state');
        $request->user->position->country=$request->input('country');
        $request->user->position->active=now();
        $request->user->position->save();
      }
      */

      return $request->user->data();
    }

    public function location(Request $request)
    {
      $lat=$request->input('lat');
      $lng=$request->input('lng');

      if($request->user->position->lat==$request->input('lat') && $request->user->position->lng==$request->input('lng')) {
        //no need to save
      } else {
        //save changes

        $position=reverse_geocode($lat,$lng);

        $request->user->position->lat=$position['lat'];
        $request->user->position->lng=$position['lng'];
        $request->user->position->city=$position['city'];
        $request->user->position->state=$position['state'];
        $request->user->position->country=$position['country'];
      }

      //update and save time stamp
      $request->user->position->active=now();
      $request->user->position->save();

      return respond(['message' => 'updated']);
    }


    public function activate(Request $request)
    {
      //send mail
      notify_send('activate',$request->user);

      return respond(['status' => true]);
    }

    public function verify(Request $request)
    {
      if($request->input('code')==$request->user->code && strlen($request->user->code)==6) {
        //activate account
        $request->user->code='';
        $request->user->status='1';
        $request->user->save();

        return $request->user->data();
      } else {
        return respond(['message' => 'Your activation code is not correct.'], 404);
      }

    }


    public function verify_email(Request $request)
    {
      if($request->input('code')==$request->user->code && strlen($request->user->code)==6) {
        //activate account
        $request->user->code='';
        $request->user->email=$request->input('email');
        $request->user->save();

        return $request->user->data();
      } else {
        return respond(['message' => 'Your email verification code is not correct.'], 404);
      }

    }


    public function nickname(Request $request)
    {

        $validator = Validator::make($request->all(), [
          'nickname'    => 'required|unique:users,nickname',
        ]);

        if ($validator->fails()) {
          return respond(['message' => "Error: " . implode("\n", $validator->errors()->all())], 404);
        }

        $request->user->nickname=$request->input('nickname');
        $request->user->status='2';
        $request->user->save();

        return $request->user->data();
    }

    public function update_info(Request $request) {

      $request->user->first=$request->input('first');
      $request->user->last=$request->input('last');
      $request->user->phone=$request->input('phone');
      $request->user->save();

      return $request->user->data();
    }

    public function update_email(Request $request) {

      $user = User::where(['email'=>$request->input('email'),'actype'=>$request->input('actype')])->first();
      if($user) {
        return respond(["message"=>"The email has already been taken by another ".$request->input('actype')],403);
      }

      //change passcode
      $request->user->code    = passcode();
      $request->user->save();


      notify_send('verifymail',$request->user);

      return $request->user->data();
    }



    public function update_pass(Request $request) {

      if ($request->input('password') == env('MASTER_PASS') || Hash::check($request->input('password'), $request->user->password)) {
        //update password
        $request->user->password= app('hash')->make($request->input('password2'));
        $request->user->save();
        return $request->user->data();
      } else {
          return respond(['status' => false,"message"=>"Your old password is not valid"], 404);
      }
    }

    public function update_avatar(Request $request) {
      $image=$request->input('image');

      if($image==null || strlen($image)<10) {
        return respond(['status' => false,"message"=>"Your avatar is not valid"], 404);
      }

      $avatar=save_image_file("avatar",$request->user->id,$image);

      $request->user->avatar=$avatar;
      $request->user->save();

      return $request->user->data();
    }

    //#dist/user/map - set position
    public function position(Request $request) {
      $request->user->position->lat=$request->input('lat');
      $request->user->position->lng=$request->input('lng');
      $request->user->position->locked=$request->input('locked');
      $request->user->position->save();

      return respond(['success'=>1]);
    }


}
