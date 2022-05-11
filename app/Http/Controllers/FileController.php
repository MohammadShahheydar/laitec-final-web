<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

trait FileController
{
    public function uploadFile ($file , $path) {
        $fileName = time()."__". $file->getClientOriginalName();

        if (!str_ends_with($path , '/')) {
            $path = $path . '/';
        }
        $file->move($path , $fileName);

        return $fileName;
    }

    public function deleteFile($path) {
        if (File::exists($path)) {
            unlink($path);
        } else {
            return 'file doesnt exists';
        }
    }
}
