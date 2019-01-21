<?php
namespace App\Helper;

class UploadPhoto {
    static function upload($file){
        if (!$file)
            return null;

        $file_name =  time().rand(0,9).'.'.$file->getClientOriginalExtension();
        $file_path = '/'.$file->storeAs('store/'.date('Y').'/'.date('m').'/'.date('d'), $file_name);
        

        return $file_path;
    }
}