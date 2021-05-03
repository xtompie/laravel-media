<?php

use App\Media\Image\Image;
use App\Media\MediaCreateException;
use App\Media\Image\ImageRepository;
use App\Media\Image\ImageVariant;
use App\Media\MediaRoutes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

MediaRoutes::register();

Route::get('upload', function () {
    return '<form method="post" enctype="multipart/form-data"">'
     .'<input type="hidden" name="_token" value="'.csrf_token().'">'
     .'<input type="file" name="file">'
     .'<input type="submit" value="submit">'
     .'</form>';
});

Route::post('upload', function () {
    try {
        $img = ImageRepository::instance()->createFromUpload(request()->file('file'));
    } catch (MediaCreateException $e) {
        return new JsonResponse(['error' => $e->getMessage()], 400);
    }
    session(['img' => $img->value()]);
    return new JsonResponse([
        'img' => $img->value(),
    ]);
});

Route::get('read', function () {
    abort_unless(session()->has('img'), 404);
    $img = new Image(session('img'));
    return new JsonResponse([
        'img' => $img->value(),
        'size' => $img->variants()->collect()->map(function(ImageVariant $variant) {
            return [
                'uri' => $variant->uri(),
                'variant' => $variant->variant(),
                'width' => $variant->width(),
                'height' => $variant->height(),
            ];
        }),
    ]);
});
