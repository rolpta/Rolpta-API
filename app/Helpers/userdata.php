<?php
use App\Order;
use App\User;

function tokenize($data, $user)
{
    if ($user) {
        $data['token'] = $user->token;

        $ostate = 0;
        $tstate = 0;

        if ($user->order) {
            $ostate = $user->order->ostate;
            $tstate = $user->order->tstate;
        }

        $navstate = $user->actype == 'requester' ? $ostate : $tstate;

        $info = [
            'id'       => $user->id,
            'first'    => $user->first,
            'last'     => $user->last,
            'name'     => $user->first . ' ' . $user->last,
            'actype'   => $user->actype,
            'phone'    => $user->phone,
            'email'    => $user->email,
            'email2'   => preg_replace('/(?<=.).(?=.*@)/', '*', $user->email),
            'address'  => $user->address,
            'avatar'   => $user->avatar,
            'avatar2'  => $user->avatar2,
            'status'   => $user->status,
            'order_id' => $user->order_id,
            'page'     => defined('_page') ? _page : '',
            'lat'      => $user->position->lat,
            'lng'      => $user->position->lng,
            'city'      => $user->position->city,
            'state'      => $user->position->state,
            'country'      => $user->position->country,
            'locked' => $user->position->locked,
            'ostate'   => $ostate,
            'tstate'   => $tstate,
            'navstate' => $navstate,
            'time' => time(),
        ];

        if ($user->actype == 'dispatcher') {
            $info['settings'] = array(
                'online'     => $user->online,
                'envelope'   => $user->dispatcher->envelope,
                'bag'        => $user->dispatcher->bag,
                'sack'       => $user->dispatcher->sack,
                'state'      => $user->dispatcher->state,
                'intrastate' => $user->dispatcher->intrastate,
                'abroad'     => $user->dispatcher->abroad,
                'vehicle'    => $user->dispatcher->vehicle,
            );
            //request list
            $requesters_list = [];

            $orders = Order::where(['disp_id' => $user->id, 'ostate' => 7, 'status' => 0])->get();

            foreach ($orders as $key => $order) {
                $ruser = $order->user;
                $duser = $order->dispatcher;

                $position = $order->p_city == '' ? $order->p_state : $order->p_city . ', ' . $order->p_state;

                if ($duser->position->country != $order->p_country) {
                    $position .= ', ' . $order->p_country;
                }

                //distance between requester and dispatcher
                $distance = haversineGreatCircleDistance(
                $ruser->position->lat, $ruser->position->lng, $duser->position->lat, $duser->position->lng);

                //distance from pickup location
                /*$distance = haversineGreatCircleDistance(
                    $order->p_lat, $order->p_lng, $duser->position->lat, $duser->position->lng);
                */

                $result[$key]['distance'] = round($distance * 0.000621371192); //miles

                $requesters_list[] = array(
                    'order_id'   => $order->id,
                    'user_id'    => $ruser->id,
                    'name'       => $ruser->name,
                    'avatar'     => $ruser->avatar,
                    'state'      => $order->p_state,
                    'country'    => $order->p_country,
                    'lat'        => $order->p_lat,
                    'lng'        => $order->p_lng,
                    'position'   => $position,
                    'created_at' => $order->created_at->diffForHumans(),
                    'distance'   => round($distance * 0.000621371192), //miles
                );

            }

            $info['requesters_list'] = $requesters_list;

            /*
        select o.id order_id,concat(u.first,' ',u.last) name,u.id user_id,p.lat,p.lng,p.city,p.state,p.country,o.disp_req created_at from orders o
        left join users u on o.user_id=u.id
        left join positions p on p.user_id=u.id
        where o.status=0 and o.ostate=7 and  o.disp_id=$user_id
         */

        }

        $data = array_merge($data, $info);

    }

    return respond($data);
}
