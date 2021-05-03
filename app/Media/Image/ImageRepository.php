<?php

namespace App\Media\Image;

use App\Media\MediaCreateException;
use App\Media\MediaNotFoundException;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Xtompie\Lainstance\Instance;
use Xtompie\Lainstance\Shared;

class ImageRepository implements Shared
{
    use Instance;

    /**
     * @return FilesystemAdapter
     */
    public function disk()
    {
        return Storage::disk();
    }

    /**
     * @return string
     */
    public function diskDirectory()
    {
        return 'image';
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
     * @param UploadedFile $upload
     * @param ImageSpace $space directory for additional organization  eg. `avatars`, `foobar/type/a`
     * @return Image
     * @throws RuntimeException
     */
    public function createFromUpload($upload, ImageSpace $space = null)
    {
        ImageCreateFromUploadValidator::validate($upload);

        $image = new Image(
            ImageSpawn::spawn($space ?: ImageSpace::default(), $upload->getClientOriginalName())
        );

        $pathinfo = pathinfo($this->diskPath($image->value()));
        if (false === $this->disk()->putFileAs($pathinfo['dirname'], $upload, $pathinfo['basename'])) {
            throw new MediaCreateException('Internal error');
        }

        event(new ImageCreated($image));

        return $image;
    }

    /**
     * @param [type] $value
     * @return Image
     */
    public function findByValue($value)
    {
        return new Image($value);
    }
}
