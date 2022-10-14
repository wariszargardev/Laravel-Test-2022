<?php

namespace App\Traits;

use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

trait ImageTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndUpload(Request $request, $fieldname = 'image', $directory = 'images' ) {

        if( $request->hasFile( $fieldname ) ) {

            if (!$request->file($fieldname)->isValid()) {

                flash('Invalid Image!')->error()->important();

                return redirect()->back()->withInput();

            }

            return $request->file($fieldname)->store($directory, 'public');

        }

        return null;

    }

    public function downloadImage($id){
        $image = UserImage::find($id);
        $file_name = $image->image;
        if(isFileExists($file_name)){
            $file = Storage::disk('public')->download($file_name);
            return $file;
        }
        return "No image found, please contact with user";
    }

    public function showImage($id){
        $image = UserImage::find($id);
        $file_name = $image->image;

        // preview
        $file = Storage::disk('public')->get($file_name);

        return (new Response($file, 200))
            ->header('Content-Type', 'image/jpeg');

    }
}
