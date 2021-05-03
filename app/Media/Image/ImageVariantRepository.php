<?php

namespace App\Media\Image;

use Illuminate\Support\Str;
use Xtompie\Lainstance\Instance;
use Xtompie\Lainstance\Shared;

class ImageVariantRepository implements Shared
{
    use Instance;


    /**
     * @return FilesystemAdapter
     */
    public function disk()
    {
        return ImageRepository::instance()->disk();
    } 

    /**
     * @return string
     */
    public function diskDirectory()
    {
        return 'cache/image';
    }

    /**
     * @return string
     */
    public function diskPath($path)
    {
        return $this->diskDirectory() . '/' . $path;
    }
    /**
     * @return string
     */
    public function fullPath($path)
    {
        return $this->disk()->path($this->diskPath($path));
    }    

    /**
     * @return string
     */
    public function uriPrefix()
    {
        return config('media.image.uri');
    }

    /**
     * @param Image $image
     * @return ImageVariantCollection
     */
    public function findAllForImage(Image $image)
    {
        return new ImageVariantCollection(
            collect(config('media.image.variant'))
                ->map(function($config, $name) use ($image) {
                    return $this->findByInput($image, $name);
                })
                ->values()
                ->toArray()
        );
    }

    /**
     * @param Image $input
     * @param string $variant
     * @return ImageVariant
     */
    public function findByInput(Image $input, $variant)
    {
        return new ImageVariant($input->value(), $variant);
    }

    /**
     * @param string $path
     * @return ImageVariant
     */
    public function findByOutput($path)
    {
        list($value, $variant) = ImageVariantSuffix::pull($path);
        return new ImageVariant($value, $variant);
    }

    /**
     * @param string $path
     * @return ImageVariant|null
     */
    public function finByDiskPath($path)    
    {
        $diskDirectory = ImageVariantRepository::instance()->diskDirectory() . '/';
        if (!Str::startsWith($path, $diskDirectory)) {
            return null;
        }

        $path = substr($path, strlen($diskDirectory));

        return $this->findByOutput($path);
    }

    /**
     * @param string $uri
     * @return ImageVariant|null
     */
    public function findByUri($uri)
    {
        $prefix = ImageVariantRepository::instance()->uriPrefix();
        if (!Str::startsWith($uri, $prefix)) {
            return null;
        }

        $uri = substr($uri, strlen($prefix));

        list($value, $variant) = ImageVariantSuffix::pull($uri);
        return new ImageVariant($value, $variant);
    }    

    /**
     * @param string $uri
     * @return ImageVariant|null
     */
    public function findByRequestPath($uri)
    {
        return $this->findByUri('/' . $uri);
    }        
}
