<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {

            $data = [];

            $request_body = file_get_contents('php://input');
            if (strlen($request_body) > 3) {

              //try normal json
              $data = @json_decode($request_body,1);

              //try : email=diltony%40yahoo.com&password=lagos
              if(empty($data)) {
                @parse_str($request_body, $data);
              }

            }

            //$data = $request->json()->all();
            $request->request->replace(is_array($data) ? $data : []);
        }

        //add the application key
        if ($request->header('appkey')) {
            $key = explode(' ', $request->header('appkey'));
            $request->request->add(['actype' => $key[0]]); //add request
            $request->request->add(['appkey' => $key[0]]); //add request
            $request->request->add(['actype' => $key[0]]); //add request
            define('actype', $key[0]);
            define('appkey', $key[0]);

            //validate key
            if ($key[0] != 'requester' && $key[0] != 'dispatcher') {
                return response("Your application key is not valid", 401);
            }
        }

        if ($request->header('page')) {
            $key = explode(' ', $request->header('page'));
            $request->request->add(['_page' => $key[0]]); //add request
            define('_page', $key[0]);
        }

        return $next($request);
    }
}
