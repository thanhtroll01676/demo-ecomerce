<?php

use App\MyLibrary\Facades\Tool;

if( ! function_exists('get_thumbnail')){
    function get_thumbnail($subfolder_filename, $suffix = '_thumb'){
        return Tool::getThumbnail($subfolder_filename, $suffix);
    }
}

if( ! function_exists('get_vnd')){
    function get_vnd($number){
        return Tool::getVND($number);
    }
}