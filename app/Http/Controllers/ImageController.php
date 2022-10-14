<?php

namespace App\Http\Controllers;

use App\Models\UserImage;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $userImage = new UserImage();
        $userImage->image =  $this->verifyAndUpload($request);
//        $input['image'] = $this->verifyAndUpload($request);
//        $input['user_id'] = Auth::id();
//
//        UserImage::create($input);

        $user = Auth::user();

        $user->images()->save($userImage);

        return back()
            ->with('success','record created successfully.');

    }

    public function show(){
        $user = Auth::user();
        $images = $user->images;

        return view('images', compact('images'));
    }

    function downloadFile($id){

        return $this->downloadImage($id);
    }

}
