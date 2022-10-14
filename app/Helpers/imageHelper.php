<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function isFileExists($imageName){
    if(Storage::exists('public/'.$imageName)) {
        return true;
    }
    return false;
}


function deleteFile($imageName){
    if(isFileExists($imageName)){
        Storage::delete('public/'.$imageName);
        return true;
    }
    return false;
}

function printAll($data){
    echo "<pre>";
    print_r($data);
    die();
}
