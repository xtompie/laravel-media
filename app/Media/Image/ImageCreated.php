<?php

namespace App\Media\Image;

class ImageCreated
{
    /** @var Image */
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Image
     */
    public function image()
    {
        return $this->image;
    }
}
