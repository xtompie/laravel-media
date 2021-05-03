<?php

namespace App\Media\Image;

use App\Media\MediaCreateException;
use Illuminate\Http\UploadedFile;

class ImageCreateFromUploadValidator
{
    /**
     * @param UploadedFile $upload
     * @throws RuntimeException
     */
    public static function validate($upload)
    {
        if (!$upload instanceof UploadedFile) {
            throw new MediaCreateException('File required');
        }

        $validate = validator(
            [
                'upload' => $upload,
            ],
            [
                'upload' => [
                    'required',
                    'image',
                    'mimes:' . implode(',', config('media.image.extension')), 
                    'max:2048',
                ],
            ]
        );

        if ($validate->fails()) {
            throw new MediaCreateException($validate->errors()->first());
        }
    }
}
