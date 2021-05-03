<?php

namespace App\Media\Image;

use Illuminate\Routing\Controller;

class ImageVariantGeneratorController extends Controller
{

    public function __invoke()
    {
        $variant = ImageVariantRepository::instance()->findByRequestPath(request()->path());
        abort_unless($variant, 404);
        abort_unless($variant->generate(), 404);
        return response()->file($variant->fullPath())->setStatusCode(201);
    }

}
