<?php

namespace App\Media\Image;

class ImageVariantCreated
{
    /** @var ImageVariant */
    protected $image;

    public function __construct(ImageVariant $image)
    {
        $this->image = $image;
    }

    /**
     * @return ImageVariant
     */
    public function image()
    {
        return $this->image;
    }
}
