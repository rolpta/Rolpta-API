<?php

function save_image_file($tag, $id, $base64_string)
{
    $time      = time();

    $shortname = "{$tag}_{$id}_{$time}";

    $saveAs = "uploads/$shortname";


    //remove old files
    $opath=base_path() . "/public/img/uploads/{$tag}_{$id}";
    $files = (array) glob("{$opath}*.{jpg,png}", GLOB_BRACE);

    foreach($files as $file) {
      unlink("$file");
    }

    //write new files
    write_image_file($saveAs, $base64_string);

    return $shortname."_3.png";
}

function write_image_file($saveAs, $base64_string)
{
    //BASE_PATH
    $base64_string = str_replace('data:image/jpeg;base64,', '', $base64_string);
    $base64_string = str_replace('data:image/png;base64,', '', $base64_string);


    $output_file = base_path() . "/public/img/" . $saveAs . "_1.png";

    $thumb_file = base_path() . "/public/img/" . $saveAs . "_3.png";

    // open the output file for writing
    $ifp = fopen($output_file, 'wb');

    // we could add validation here with ensuring count( $data ) > 1
    fwrite($ifp, base64_decode($base64_string));

    // clean up the file resource
    fclose($ifp);

    makeThumbnails($output_file, $thumb_file, 200, 150);
}

function makeThumbnails($src, $thumb, $thumbnail_width = 100, $thumbnail_height = 100)
{
    $arr_image_details = getimagesize($src);
    $original_width    = $arr_image_details[0];
    $original_height   = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width  = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width  = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt          = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt          = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt          = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom($src);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        //write to thumbnail
        $imgt($new_image, $thumb);
    }
}

function sortBy($field, &$array, $direction = 'asc')
{
    usort($array, create_function('$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];

        if ($a == $b) return 0;

        $direction = strtolower(trim($direction));

        return ($a ' . ($direction == 'desc' ? '>' : '<') . ' $b) ? -1 : 1;
    '));

    return true;
}

function dhtmlconsole($msg = '')
{
    static $pos = 0;
    $pos++;
    header('X-DHTML-CONSOLE-MSG' . $pos . ': ' . json_encode($msg));
}

//api responder
function respond($data = [], $status = 200)
{
    $data = (array) $data;
    return response()->json($data, $status);
}

//generate a non-unique code
function passcode()
{
    return mt_rand(100000, 999999);
}

function notify_send($template, $user)
{
    return \App\Notify::compose($template, $user)->send();
}

function now()
{
    $now = new DateTime();
    return $now;
}
