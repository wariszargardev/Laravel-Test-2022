<?php

namespace App\Http\Controllers;

use App\Events\EmailSendEvent;
use App\Mail\SendImageLinkEmail;
use App\Models\ImageSharing;
use App\Models\User;
use App\Models\UserImage;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;


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

    function deleteFile($id){
        $image = UserImage::find($id);
        $file_name = $image->image;
        if(deleteFile($file_name)){
            echo "Image deleted";
        }
        else{
            echo "Image not deleted";
        }
    }

    function setImageVisibility($id){
        $image = UserImage::find($id);
        $users = User::where('id', '!=' , Auth::id())->get();

        return view("update_image_status", compact('image', 'users', 'id'));
    }

    function updateImageVisibility(Request $request,$id){
        $image = UserImage::find($id);
        $image->visibility = $request->visibility;
        $image->save();

        foreach ($request->userIds as $id){
            $imageSharing = new ImageSharing();
            $imageSharing->user_id = $id;
            $image->user_images()->save($imageSharing);
        }

        $users = User::whereIn('id', $request->userIds)->pluck('email');
//        foreach ($users as $user){
//            Mail::to($user)->send(new \App\Mail\SendImageLinkEmail($id));
//
//        }

        $on = \Carbon\Carbon::now()->addSecond(10);

//        dispatch(new \App\Jobs\SendEmailJob($id, $users))->delay($on);
//        dispatch(new \App\Jobs\SendEmailJob($id, $users));


        event (new EmailSendEvent($id, $users));


        return redirect()->back();
    }

}
