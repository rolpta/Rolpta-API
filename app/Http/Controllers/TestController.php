<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notify;
use App\User;
use App\Order;
use App\Dispatcher;

class TestController extends Controller
{
  public function test(Request $request)
  {
    return respond($request->all());

  }

    public function test1(Request $request)
    {
      $user = User::where('id',1)->first();
      echo $user->rate;
      die();

      echo $user->dispatcher->id;
      die('x2');

      $user = User::where('id', 26)->first();

      echo $user->order_id ." - " . $user->order->id;

      die();

      $order = Order::where('id', 12)->first();

      echo $order->user->id;
      die('x');

      /*
      $user = User::where('id', 1)->first();
      $user->setToken();
      $user->save();
      echo "saved";
      //$token=generate_token();
      //echo $token;
      die();
      */

      $users=USER::all();

      foreach($users as $user) {
        //$user->password = app('hash')->make($user->password);
        $user->setToken();
        $user->save();
        echo "<li>".$user->id . ' - ' . $user->password;
      }

      //$user = User::where('id', 1)->first();

      //var_dump($user);
      //Notify::compose('register',$user)->send();
      //$notify=Notify::compose('activate',$user);


      exit();

      //Notify->resend_verification();

      //$token = "233535";


        Mail::raw('Here is your account verification token', function ($message) {
            $message->from(env('MAIL_FROM_EM'), env('MAIL_FROM_NAME'));

            $message->subject(env('APP_NAME') . ' - account verification');
            $message->to(['diltony@yahoo.com']);
        });

        exit();
    }

    public function reset(Request $request)
    {
      echo "Reset stuffs";

      //truncate orders
      Order::query()->truncate();

      $affected = \DB::table('users')->update(array('order_id' => 0));


      //$user = User::where('id', 26)->first();
      //echo $user->position->id;
    }

}
