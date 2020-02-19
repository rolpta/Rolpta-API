<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

class ActionsController extends Controller
{

    public function back(Request $request)
    {
        $order = Order::where('id', $request->user->order_id)->first();

        if ($order) {
            switch ($request->user->actype) {
                case 'requester':

                    switch ($order->ostate) {
                        case "1":
                        case "2":
                        case "3":
                        case "4":
                        case "5":
                        case "6":
                            $order->ostate--;
                            break;

                        case "7": //dispatchers reselect
                            $order->ostate--;
                            $order->disp_id = 0;
                            break;

                        case "8": //tracking page
                            $order->ostate = 9; //rate
                            $order->tstate = 6; //cancelled
                            break;
                    }
                    break;
                case 'dispatcher':

                    break;
            }
            //save changes
            $order->save();
            return $request->user->data();
        } else {
            return respond([], 201);
        }
    }

    public function rate(Request $request)
    {
        $rating  = (int) $request->input("rating");
        $comment = $request->input("comment");

        if ($request->user->actype == 'requester') {
            $request->user->order->comment_r = $comment;
            $request->user->order->rate_r    = $rating;
            $request->user->order->ostate    = 15;
            $request->user->order->status    = 1;
            $request->user->order->save();
        } else {
            $request->user->order->comment_d = $comment;
            $request->user->order->rate_d    = $rating;
            $request->user->order->tstate    = 15;
            $request->user->order->save();
        }

        //free this user as transaction is finished
        $request->user->order_id = 0;
        $request->user->save();

        return $request->user->data();
    }

    public function locate(Request $request)
    {
    }
}
