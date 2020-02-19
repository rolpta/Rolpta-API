<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    // start pickup @ dispatcher
    public function start(Request $request)
    {
        $request->user->order->message = $request->user->name . " is on the way to delivery location";
        $request->user->order->tstate  = 2;

        //record current location before dispatch
        $request->user->order->d_lat2 = $request->user->position->lat;
        $request->user->order->d_lng2 = $request->user->position->lng;

        //add image
        $image=save_image_file("package",$request->user->order->id,$request->input('photo'));
        $request->user->order->scan=$image;

        $request->user->order->save();
        return $request->user->data();
    }

    // start deliver @ dispatcher
    public function deliver(Request $request)
    {
        $request->user->order->message = $request->user->name . " has delivered, please confirm delivery and make payment";
        $request->user->order->tstate  = 3;
        $request->user->order->save();
        return $request->user->data();
    }

}
