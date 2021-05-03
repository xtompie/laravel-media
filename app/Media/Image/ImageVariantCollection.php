<?php

namespace App\Media\Image;

use Illuminate\Support\Collection;

class ImageVariantCollection
{
    /** @var ImageVariant[] */
    protected $images;

    /**
     * @param array $images
     */
    public function __construct(array $images)
    {
        $this->images = $images;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->images;
    }

    /**
     * @return Collection
     */
    public function collect()
    {
        return collect($this->all());
    }
}
