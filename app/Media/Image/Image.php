<?php

namespace App\Media\Image;

class Image
{
    /** @var string */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return ImageVariantCollection
     */
    public function variants()
    {
        return ImageVariantRepository::instance()->findAllForImage($this);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        $repo = ImageRepository::instance();
        return $repo->disk()->exists($repo->diskPath($this->value()));
    }

    /**
     * @return string
     */
    public function fullPath()
    {
        return ImageRepository::instance()->fullPath($this->value());
    }
}
