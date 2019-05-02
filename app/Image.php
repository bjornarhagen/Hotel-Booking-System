<?php

namespace App;

use File;
use Storage;
use \Exception;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function getUrlAttribute($value) {
        if ($this->is_default) {
            return $value;
        }

        return asset('storage/' . $value);
    }

    public static function upload(User $user, $uploaded_file, String $path) : ? Image
    {
        if ($uploaded_file === null) {
            return null;
        }

        try {
            // Don't process files that are too large (10mb)...
            // This acts as a fallback. We should validate before sending it to this method
            $image_size_mb = $uploaded_file->getSize() / (1000*1000);
            if ($image_size_mb > 10) {
                return null;
            }

            $image_url = $path . '/' . str_random(20) . '.' . $uploaded_file->getClientOriginalExtension();

            // Create image
            $image = new Image;
            $image->user_id = $user->id;
            $image->url = $image_url;

            // Save the image
            Storage::put($image_url, File::get($uploaded_file->path()));
            
            // In newer versions, use this:
            // Storage::put($image_url, $uploaded_file->get());
            
            // Everything went well, let's put the image in the db
            $image->save();

            return $image;
        } catch (Exception $e) {
            report($e);
        }

        return null;
    }
}
