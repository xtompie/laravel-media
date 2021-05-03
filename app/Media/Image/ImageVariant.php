<?php

namespace App\Media\Image;

class ImageVariant
{
    /** @var string */
    protected $base;

    /** @var string */
    protected $variant;

    /**
     * @param string $base
     * @param string $variant
     */
    public function __construct($base, $variant)
    {
        $this->base = $base;
        $this->variant = $variant;
    }
   
    /**
     * @return string
     */
    public function variant()
    {
        return $this->variant;
    }

    /**
     * @return string
     */
    public function base()
    {
        return $this->base;
    } 


    /**
     * @return string
     */
    public function uri()
    {
        return ImageVariantRepository::instance()->uriPrefix() . $this->value();
    }

    public function value()
    {
        return ImageVariantSuffix::put($this->base, $this->variant());
    }

    /**
     * @return string
     */
    public function fullPath()
    {
        return ImageVariantRepository::instance()->fullPath($this->value());
    }
 
    /**
     * @return Image
     */
    public function image()
    {
        return ImageRepository::instance()->findByValue($this->base());
    }   


    /**
     * @return string
     */
    public function width()
    {
        return config("media.image.variant.{$this->variant()}.w");
    }

    /**
     * @return string
     */
    public function height()
    {
        return config("media.image.variant.{$this->variant()}.h");
    }

    public function generate()
    {
        return ImageVariantGenerator::instance()->generate($this);
    }
}
