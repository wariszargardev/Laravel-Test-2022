<?php

namespace App\Http\Middleware;

use App\Models\UserImage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckImageVisibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $image_id = $request->route()->parameter('id');
        $user_id = Auth::id();
        $userImage = UserImage::where('id', $image_id)->orWhere('user_id',$user_id)->first();
        if($userImage){
            $imageVisibility = $userImage->visibility;
            if($imageVisibility == "public"){
                return $next($request);
            }
            elseif ($imageVisibility == "hidden" && $user_id == $userImage->user_id){
                return $next($request);
            }
            else{
                return $next($request);
            }
        }
        else{
            return "No image available";
        }
    }
}
