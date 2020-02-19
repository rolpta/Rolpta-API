<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

  protected $guarded = [];

  //user that made the order
  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function dispatcher()
  {
      return $this->belongsTo('App\User','disp_id');
  }

  public function distancia() {
    $miles=distance($this->p_lat,$this->p_lng,$this->d_lat,$this->d_lng,'M');
    $kilo=distance($this->p_lat,$this->p_lng,$this->d_lat,$this->d_lng,'K');

    //check the type
    if($this->d_country != $this->p_country) {
        $this->category="abroad";
    } else if($this->d_state!=$this->p_state) {
        $this->category="local";
    } else {
        $this->category="intrastate";
    }


    //calculate price
    $distance=$miles;


    $price=0;
    $units=(int) $this->items;

    //base price
    if($distance<100) {
        $base_price=15*$distance*$units;
    } else {
        $base_price=10*$distance*$units;
    }

    //minimum base price
    if($base_price<200) {$base_price=200;}

    switch($this->package) {
        case "bag":
            $pkg_price= (3*$distance*$units);
        break;
        case "sack":
            $pkg_price= (5*$distance*$units);
        break;
       default:
        $pkg_price=0;
    }


    $this->price=$base_price + $pkg_price;
    $this->base_price=$base_price;
    $this->pkg_price=$pkg_price;

    $this->miles=$miles;
    $this->kilo=$kilo;


  }


  //small
  public function getRAvatarAttribute() {
    return url('img/uploads/'.$this->attributes['r_avatar']);
  }

  //large
  public function getRAvatar2Attribute() {
    return str_replace('_3','_1',$this->r_avatar);
  }


  public function getScanAttribute() {
    return url('img/uploads/'.$this->attributes['scan']);
  }

  //large
  public function getScan2Attribute() {
    return str_replace('_3','_1',$this->scan);
  }
}
