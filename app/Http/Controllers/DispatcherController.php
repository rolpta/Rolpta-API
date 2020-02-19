<?php

namespace App\Http\Controllers;

use App\Dispatcher;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class DispatcherController extends Controller
{

    //peek request @ dispatcher
    public function peek(Request $request)
    {
        $order = order::where(['id' => $request->input('order_id')])->first();
        if ($order) {
            $position = $order->p_city == '' ? $order->p_state : $order->p_city . ', ' . $order->p_state;

            if ($request->user->position->country != $order->p_country) {
                $position .= ', ' . $order->p_country;
            }

            $result = array(
                'order_id'    => $order->id,
                'hash'        => $order->hash,
                'name'        => $order->user->name,
                'avatar'        => $order->user->avatar,
                'r_name'        => $order->r_name,
                'r_phone'        => $order->r_phone,
                'r_avatar'        => $order->r_avatar,
                'package'     => $order->package,
                'items'       => $order->items,
                'description' => $order->description,
                'position'    => $position,
                'p_address'   => $order->p_address,
                'd_address'   => $order->d_address,
            );
            return respond($result);
        } else {
            return respond(['message' => "Order not found"], 404);
        }
    }

    //accept order @ dispatcher
    public function accept(Request $request)
    {
        $order = order::where(['id' => $request->input('order_id')])->first();
        if ($order) {

            //bind the order dispatcher
            $request->user->order_id = $request->input('order_id');
            $request->user->save();

            $order->p_lat2      = $request->user->position->lat;
            $order->p_lng2      = $request->user->position->lng;

            $order->ostate      = 8;
            $order->tstate      = 1;
            $order->message     = $order->dispatcher->name . " is on the way to pickup package";
            $order->accepted_at = now();
            $order->save();

            return respond(['success' => 1]);
        } else {
            return respond(['message' => "Order not found"], 404);
        }
    }

    public function ping(Request $request)
    {
        $request->user->order->disp_id  = $request->input('disp_id');
        $request->user->order->disp_req = now();
        $request->user->order->ostate   = 7;
        $request->user->order->save();

        return $request->user->data();
    }

    //update settings
    public function update(Request $request)
    {
        $request->user->online = $request->input('online') == 'on' ? 1 : 0;
        $request->user->save();

        $request->user->dispatcher->envelope   = $request->input('envelope') == 'on' ? 1 : 0;
        $request->user->dispatcher->bag        = $request->input('bag') == 'on' ? 1 : 0;
        $request->user->dispatcher->sack       = $request->input('sack') == 'on' ? 1 : 0;
        $request->user->dispatcher->state      = $request->input('state') == 'on' ? 1 : 0;
        $request->user->dispatcher->intrastate = $request->input('intrastate') == 'on' ? 1 : 0;
        $request->user->dispatcher->abroad     = $request->input('abroad') == 'on' ? 1 : 0;
        $request->user->dispatcher->vehicle    = $request->input('vehicle');
        $request->user->dispatcher->save();

        return $request->user->data();
    }

    //track dispatcher @ requester
    public function track(Request $request)
    {
      $to_time = strtotime("2008-12-13 10:42:00");
      $from_time = strtotime("2008-12-13 10:21:00");
      //echo round(abs($to_time - $from_time) / 60,2). " minute";


        $result = [
            'order_id'   => $request->user->order->id,
            'hash'   => $request->user->order->hash,
            //how long ago was it accepted in minutes
            'accepted_at' => round(abs(time() - strtotime($request->user->order->accepted_at)) / 60,2),
            'name'       => $request->user->order->dispatcher->name,
            'user_id'    => $request->user->id,
            'price'      => $request->user->order->price,
            'lat'        => $request->user->order->dispatcher->position->lat,
            'lng'        => $request->user->order->dispatcher->position->lng,
            'city'       => $request->user->order->dispatcher->position->city,
            'state'      => $request->user->order->dispatcher->position->state,
            'country'    => $request->user->order->dispatcher->position->country,
            'disp_req'   => $request->user->order->disp_req,
            'p_lat'      => $request->user->order->p_lat,
            'p_lng'      => $request->user->order->p_lng,
            'p_lat2'      => $request->user->order->p_lat2,
            'p_lng2'      => $request->user->order->p_lng2,
            'd_lat'      => $request->user->order->d_lat,
            'd_lng'      => $request->user->order->d_lng,
            'd_lat2'      => $request->user->order->d_lat2,
            'd_lng2'      => $request->user->order->d_lng2,
            'p_gaddress' => $request->user->order->p_gaddress,
            'p_address'  => $request->user->order->p_address,
            'd_gaddress' => $request->user->order->d_gaddress,
            'd_address'  => $request->user->order->d_address,
            'ostate'     => $request->user->order->ostate,
            'tstate'     => $request->user->order->tstate,
            'message'    => $request->user->order->message,
            'scan' => $request->user->order->scan,
            'scan2' => $request->user->order->scan2,

            'phone'      => $request->user->order->dispatcher->phone,
            'avatar'      => $request->user->order->dispatcher->avatar,
            'vehicle'    => $request->user->order->dispatcher->dispatcher->vehicle,
            'created_at' => $request->user->order->created_at->diffForHumans(),
            'position'   => $result['city'] == '' ? $result['state'] : $result['city'] . ', ' . $result['state'],
        ];

        return respond($result);
    }

    function list(Request $request) {
        $users = User::where(['actype' => 'dispatcher', 'online' => 1, 'order_id' => 0])->get();

        $result = [];
        foreach ($users as $user) {
            $position = $user->position->city == '' ? $user->position->state : $user->position->city . ', ' . $user->position->state;

            if ($user->position->country != $request->user->position->country) {
                $position .= ', ' . $user->position->country;
            }

            $distance = haversineGreatCircleDistance(
                $request->user->position->lat,
                $request->user->position->lng,
                $user->position->lat,
                $user->position->lng
            );

            $result[] = array(
                'user_id'  => $user->id,
                'name'     => $user->name,
                'avatar'     => $user->avatar,
                'rate' => $user->rate, //rating of dispatcher
                'vehicle'  => $user->dispatcher->vehicle,
                'state'    => $user->position->state,
                'country'  => $user->position->country,
                'lat'      => $user->position->lat,
                'lng'      => $user->position->lng,
                'position' => $position,
                'distance' => round($distance * 0.000621371192), //miles
            );
        }
        sortBy('distance', $result, 'asc');

        return respond($result);
    }

    //check selected dispatcher
    public function select(Request $request)
    {

        //dispatcher is the user here
        $user = $request->user->order->dispatcher;

        $result = array(
            'user_id' => $user->id,
            'name'    => $user->name,
            'phone'   => $user->phone,
            'avatar'     => $user->avatar,
            'vehicle' => $user->dispatcher->vehicle,
            'state'   => $user->position->state,
            'country' => $user->position->country,
            'lat'     => $user->position->lat,
            'lng'     => $user->position->lng,
        );

        return respond($result);
    }

    //job details @ dispatcher
    public function job(Request $request)
    {

        if ($request->user->order) {
            $result = $request->user->order->toArray();
            $result['s_name']=$request->user->order->user->name;
            $result['s_phone']=$request->user->order->user->phone;
            $result['s_avatar']=$request->user->order->user->avatar;
            $result['lat']=$request->user->position->lat;
            $result['lng']=$request->user->position->lng;

            return response($result);
        } else {
          return respond(['message'=>"Order not found"],404);
        }
    }

}
