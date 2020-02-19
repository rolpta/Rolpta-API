<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // make payment @ requester
    public function make(Request $request)
    {
      $request->user->order->message = $request->user->order->dispatcher->name . " needs to be rated";
      $request->user->order->tstate=4;
      $request->user->order->ostate=9;
      $request->user->order->save();
      return $request->user->data();
    }

    // start deliver @ dispatcher
    public function confirm(Request $request)
    {
      $request->user->order->tstate=5;
      $request->user->order->save();
      return $request->user->data();
    }


}
