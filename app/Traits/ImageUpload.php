<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageUpload
{
    public function imageUpload($query, $upload_path) 
    {
        // $upload_path = $upload_path . "/";

        // $image_name = str_random(20);
        // $ext = strtolower($query->getClientOriginalExtension()); 
        // $image_full_name = $image_name . '.' . $ext;
        // $image_url = $upload_path . $image_full_name;
        // $success = $query->move($upload_path, $image_full_name);

        $path = Storage::disk('public')->put($upload_path, $query);

        return [
            'path' => "storage/" . $path,
            'file' => $query->getClientOriginalName() //$image_full_name
        ]; 
    }

    public function imageUpdateWithThumb($uploadPath, $file, $size = 500)
    {
        $time = time();
        $filename = "/storage/app/public/" . $uploadPath . "/{$time}." . $file->getClientOriginalExtension();
        Storage::disk('public')->put($filename, file_get_contents($file));

        $thumb    = "/storage/app/public/" . $uploadPath . "/thumbs/{$time}." . $file->getClientOriginalExtension();

        $image_resize = Image::make($file->getRealPath());              
        Storage::disk('public')->put($thumb, $this->resizeImage($image_resize, $size));

        return str_replace("/storage/app/public/", "", $thumb);
    }

    private function resizeImage($image, $requiredSize) {
        $width = $image->width();
        $height = $image->height();
    
        // Check if image resize is required or not
        if ($requiredSize >= $width && $requiredSize >= $height) return $image->stream();
    
        $newWidth;
        $newHeight;
    
        $aspectRatio = $width / $height;
        if ($aspectRatio >= 1.0) {
            $newWidth = $requiredSize;
            $newHeight = $requiredSize / $aspectRatio;
        } else {
            $newWidth = $requiredSize * $aspectRatio;
            $newHeight = $requiredSize;
        }
    
        $image->resize($newWidth, $newHeight)->stream();
        return $image;
    }
}