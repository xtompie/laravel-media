<?php

namespace App\Media;

use App\Media\Image\ImageVariantGeneratorController;
use Illuminate\Support\Facades\Route;

class MediaRoutes
{
    public static function register()
    {
        Route::get(
            config('media.image.uri') . '{path}',
            ImageVariantGeneratorController::class
        )
            ->where('path', '.+\.(' . implode('|', config('media.image.extension')) . ')')
        ;
    }
}
