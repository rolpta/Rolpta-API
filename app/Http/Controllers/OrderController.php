<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function pending(Request $request)
    {
        $order = Order::where('id', $request->user->order_id)->first();

        if ($order) {
            switch ($request->user->actype) {
                case 'requester':
                    $data = [
                        'id'          => $order->id,
                        'package'     => $order->package,
                        'description' => $order->description,
                        'items'       => $order->items,
                    ];
                    break;
                case 'dispatcher':
                    $data = [
                        'id' => $order->id,
                    ];
                    break;
            }
            return respond($data);
        } else {
            return respond([], 201);
        }
    }

    //initiate order - order must have been created by user model
    public function init(Request $request)
    {
        $request->user->order->package     = $request->input('package');
        $request->user->order->items       = $request->input('items');
        $request->user->order->description = $request->input('description');
        $request->user->order->ostate      = 1;

        $request->user->order->save();

        return $request->user->data();
    }

    //set pickup from requester
    public function set_pickup(Request $request)
    {
        $request->user->order->p_lat      = $request->input('p_lat');
        $request->user->order->p_lng      = $request->input('p_lng');
        $request->user->order->p_gaddress = $request->input('p_gaddress');
        $request->user->order->p_address  = $request->input('p_address');
        $request->user->order->p_city     = $request->input('p_city');
        $request->user->order->p_state    = $request->input('p_state');
        $request->user->order->p_country  = $request->input('p_country');
        $request->user->order->p_place    = $request->input('p_place');
        $request->user->order->ostate     = 2;
        $request->user->order->save();

        return $request->user->data();
    }

    public function set_destination(Request $request)
    {
        $request->user->order->d_lat      = $request->input('d_lat');
        $request->user->order->d_lng      = $request->input('d_lng');
        $request->user->order->d_gaddress = $request->input('d_gaddress');
        $request->user->order->d_address  = $request->input('d_address');
        $request->user->order->d_city     = $request->input('d_city');
        $request->user->order->d_state    = $request->input('d_state');
        $request->user->order->d_country  = $request->input('d_country');
        $request->user->order->d_place    = $request->input('d_place');
        $request->user->order->ostate     = 3;

        $request->user->order->distancia();

        $request->user->order->save();

        return $request->user->data();
    }

    public function details(Request $request)
    {
        $order = Order::where('id', $request->user->order_id)->first();

        if ($order) {
            $data = $order->toArray();
            if ($order->dispatcher) {
                $data['vehicle']   = $order->dispatcher->dispatcher->vehicle;
                $data['disp_name'] = $order->dispatcher->name;
                $data['snd_name']  = $order->user->name;
                $data['avatar']  =   $request->user->actype=='requester' ? $order->dispatcher->avatar : $order->user->avatar;
            }
            return respond($data);
        } else {
            return respond([], 201);
        }
    }

    //show receiver
    public function receiver(Request $request)
    {
        $request->user->order->ostate = 4;
        $request->user->order->save();
        return $request->user->data();
    }

    public function set_receiver(Request $request)
    {
        $request->user->order->r_name     = $request->input('name');
        $request->user->order->r_phone    = $request->input('phone');
        $request->user->order->r_dispatch = $request->input('dispatch');

        $image=$request->input('image');
        if ($image != null && strlen($image) > 10) {
          $request->user->order->r_avatar = save_image_file("receiver", $request->user->order->id, $image);
        }


        $request->user->order->ostate = 5;
        $request->user->order->save();

        return $request->user->data();
    }

    //goto list of dispatchers
    public function show_dispatchers(Request $request)
    {
        $request->user->order->ostate = 6;
        $request->user->order->save();
        return $request->user->data();
    }
}
