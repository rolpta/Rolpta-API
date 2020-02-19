<?php

namespace App;

use Dirape\Token\DirapeToken;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use DB;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, DirapeToken;

    protected $guarded = [];

    //token field
    protected $DT_Column = 'token';

    /**
     * Get the order record associated with the user.
     */
    public function order()
    {
        $order = $this->hasOne('App\Order', 'id', 'order_id');

        //check if order is complete so you can free requester or dispatcher
        if ($order && $order->first() != null && ($order->first()->ostate == 15 || $order->first()->tstate == 15)) {

            if (($this->actype == 'requester' && $order->first()->ostate == 15)) {
                //free requester
                $this->order_id = 0;
                $this->save();

                $order = $this->hasOne('App\Order', 'id', 'order_id');
            } else if (($this->actype == 'dispatcher' && $order->first()->tstate == 15)) {
                //free dispatcher
                $this->order_id = 0;
                $this->save();

                $order = $this->hasOne('App\Order', 'id', 'order_id');
            }

        }

        //only create if not exist for requester only
        if ($order->first() == null && $this->actype == 'requester') {
            //create order entry here if one does not exist

            //create new hash
            $latestOrder = Order::orderBy('created_at','DESC')->first();
            if($latestOrder) {
              $oid=$latestOrder->id;
            } else {
              $oid=0;
            }
            $hash = str_pad($oid + 1, 7, "0", STR_PAD_LEFT);

            $ord = \App\Order::create([
                'user_id' => $this->id,
                'hash'=>$hash
            ]);

            //append the id to the user
            $this->order_id = $ord->id;
            $this->save();

            $order = $this->hasOne('App\Order', 'id', 'order_id');
        }

        return $order;
    }

    /**
     * Get the position record associated with the user.
     */
    public function position()
    {
        $pos = $this->hasOne('App\Position', 'user_id', 'id');

        if ($pos->first() == null) {
            //create position entry here if one does not exist
            \App\Position::create([
                'user_id' => $this->id,
            ]);

            $pos = $this->hasOne('App\Position', 'user_id', 'id');
        }

        return $pos;
    }

    /**
     * Get the dispatcher record associated with the user.
     */
    public function dispatcher()
    {
        $disp = $this->hasOne('App\Dispatcher', 'user_id', 'id');

        if ($disp->first() == null && $this->actype == 'dispatcher') {
            //create position entry here if one does not exist
            \App\Dispatcher::create([
                'user_id' => $this->id,
            ]);

            $disp = $this->hasOne('App\Dispatcher', 'user_id', 'id');
        }

        return $disp;
    }

    public function getNameAttribute() {
      return $this->first.' '.$this->last;
    }

    public function getRateAttribute() {
      $avfield=$this->actype=='requester' ? "rate_r" : "rate_d";
      $field=$this->actype=='requester' ? "user_id" : "disp_id";
      $id=$this->id;

      $results = DB::select( DB::raw("select AVG($avfield) avg from orders
      where $field=$id
      group by $field;")
    );
    if(isset($results[0])) {
      $r=round($results[0]->avg);
    } else {
      $r=0;
    }
      return $r;
    }

    //small
    public function getAvatarAttribute() {
      return url('img/uploads/'.$this->attributes['avatar']);
    }

    //large
    public function getAvatar2Attribute() {
      return str_replace('_3','_1',$this->avatar);
    }

    //return tokenized data
    public function data($arr = ['status' => true])
    {
        return tokenize($arr, $this);
    }
}
