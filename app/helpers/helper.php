<?php

use Illuminate\Support\Facades\File;

if (!function_exists('admin')) {

    function admin()
    {
        return auth('admin')->check() ? auth('admin')->user() : null;
    }
}
// --------------------------------------------
function orderNumberOfRows($paginate_count = null)
{
    $paginate_count = $paginate_count ?? DASHBOARD_PAGINATE_COUNT;

    $start = 0;
    $page = request()->page ? (int) request()->page : 0;

    if ($page && $page > 0) {

        $start = ($page * $paginate_count) - $paginate_count;
        // $start = ($page * PAGINATE_COUNT) - PAGINATE_COUNT;
    }

    return $start;
}
// --------------------------------------------


if (!function_exists('fileExists')) {

    function fileExists($path)
    {
        return File::exists($path);
    }
}


// --------------------------------------------

if (!function_exists('sweetAlertFlush')) {

    function sweetAlertFlush($type = 'success',$title = '',$message = '')
    {
        session()->flash('sweet_alert',['type' => $type,'title'=> $title , 'message' => $message]);
    }
}
// --------------------------------------------


if (!function_exists('pathNoImage')) {

    function pathNoImage()
    {
        $path = public_path('images/noImage.jpg');
        return File::exists($path) ? asset('images/noImage.jpg') : null;
    }
}

// --------------------------------------------
if (!function_exists('catchErro')) {

    function catchErro($route_name, $error_catch, $message = 'some errors happend pleas try again later')
    {

        \Illuminate\Support\Facades\Log::alert($error_catch);

        sweetAlertFlush( 'error', 'error' , $message);

        return redirect()->route($route_name);
    }
}


// --------------------------------------------
// --------------------------------------------
// --------------------------------------------
// --------------------------------------------
// --------------------------------------------
// --------------------------------------------
// --------------------------------------------
