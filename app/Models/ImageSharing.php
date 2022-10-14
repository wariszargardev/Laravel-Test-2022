<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSharing extends Model
{
    use HasFactory;

    public function image(){
        return $this->belongsTo(UserImage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
