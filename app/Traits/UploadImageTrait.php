<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait {
    private static function moveFileToPublic(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('root-public')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }
}