<?php

namespace App\Media\Image;

class ImageVariantSuffix
{
    /**
     * @param string $path
     * @return array [0] => name, [1] => suffix
     */
    public static function pull($path)
    {
        $matches = null;
        preg_match(
            '/^'
            . '(?<base>.*)'
            . preg_quote(static::separator(), '/')
            . '(?<suffix>'. static::suffix() . ')'
            . '\.'
            . '(?<ext>[A-Za-z0-9]+)'
            . '$/',
            $path,
            $matches
        );
        return [$matches['base'] . '.' . $matches['ext'], $matches['suffix']];
    }

    /**
     * @param string $name
     * @param string $suffix
     * @return string
     */
    public static function put($name, $suffix)
    {
        $matches = null;
        preg_match(
            '/^'
            . '(?<base>.*)'
            . '\.'
            . '(?<ext>[A-Za-z0-9]+)'
            . '$/',
            $name,
            $matches
        );
        return $matches['base'] . static::separator() . $suffix .  '.' . $matches['ext'];
    }

    protected static function suffix()
    {
        return '[a-z]+';
    }

    protected static function separator()
    {
        return '-';
    }
}
