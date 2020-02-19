<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Notify extends Model
{

    public $message = null;

    public static function compose($template, $user)
    {
        $tpl = config('notify.' . $template);

        $data = (array) $user;

        $search  = ['[first]', '[last]', '[name]', '[code]'];
        $replace = [$user->first, $user->last, $user->name, $user->code];

        $tpl['subject'] = str_replace($search, $replace, $tpl['subject']);
        $tpl['body']    = str_replace($search, $replace, $tpl['body']);

        $tpl['to'] = $user->email; //receiver

        $obj          = new Notify;
        $obj->message = (object) $tpl;

        return $obj;
    }

    public function send()
    {
        $mdata = $this->message;

        Mail::send(array(), array(), function ($message) use ($mdata) {
            $message->to($mdata->to)
                ->subject($mdata->subject)
                ->from(env('MAIL_FROM_EM'), env('MAIL_FROM_NAME'))
                ->setBody($mdata->body, 'text/html');
        });

    }

}
