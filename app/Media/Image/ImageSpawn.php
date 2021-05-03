<?php

namespace App\Media\Image;

use Illuminate\Support\Str;

class ImageSpawn
{
    /**
     * @param ImageSpace $space directory name eg. `avatars`, `foobar/type/a`
     * @param string $name filename
     * @return string
     */
    public static function spawn(ImageSpace $space, $name)
    {
        list($base, $ext) = static::resolveNameAndExtension($name);
        $id = static::id();
        return
            $space->space()
            . '/' .substr($id, 0, 2)
            . '/' . substr($id, 2, 2)
            . '/' . $id . '-' . Str::slug($base)
            . '.' . $ext
        ;
    }

    /**
     * @param string $name
     * @return array [0] => name, [1] => extension
     */
    protected static function resolveNameAndExtension($name)
    {
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $name = substr($name, 0, - strlen($ext) - 1); // -1 for dot character before extentsion

        return [$name, $ext];
    }

    /**
     * @return string
     */
    protected static function id()
    {
        return Str::lower(Str::uuid()) ;      
    }
}
