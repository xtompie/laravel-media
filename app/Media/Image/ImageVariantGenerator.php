<?php

namespace App\Media\Image;

use Xtompie\Lainstance\Instance;
use Xtompie\Lainstance\Shared;
use Intervention\Image\Facades\Image as InterventionImage;

class ImageVariantGenerator implements Shared
{
    use Instance;

    public function generate(ImageVariant $variant)
    {
        if (!$variant->image()->exists()) {
            return false;
        }

        $input = ImageRepository::instance()->fullPath($variant->image()->value());
        $output = ImageVariantRepository::instance()->fullPath($variant->value());
        $config = config('media.image.variant.' . $variant->variant());

        $this->ensureDirForFilePath($output);

        $img = InterventionImage::make($input);
        if ($config['type'] == 'resize') {
            $img = $img->resize($config['w'], $config['h']);
        } 
        else if ($config['type'] == 'crop') {
            $img = $img->fit($config['w'], $config['h']);
        }
        $img->save($output);

        return true;
    }

    protected function ensureDirForFilePath($path)
    {
        $dir = dirname($path);

        if (file_exists($dir)) {
            return;
        }

        mkdir($dir, 0777, true);
    }
}
