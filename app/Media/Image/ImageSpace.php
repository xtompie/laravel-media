<?php

namespace App\Media\Image;

class ImageSpace
{
    /** @var string */
    protected $space;

    /**
     * @return static
     */
    public static function default()
    {
        return new static('default');
    }

    /**
     * @return string
     */
    public function space()
    {
        return $this->space;
    }

    /**
     * @param string $space
     */
    protected function __construct($space)
    {
        $this->space = $space;
    }
}
