<?php

namespace App\MyLibrary;

class ToolFactory {
    public function getThumbnail($subfolder_filename, $suffix = '_thumb'){
        if($subfolder_filename){ // nếu khác rỗng
            // example: 2018-05/3a7e0c285e71185a89ec7e22e6745d1c.jpg
            return preg_replace("#(.*)\.(.*)#i", "$1{$suffix}.$2", $subfolder_filename);
        }
        return '';
    }

    public function getVND($number){
        return number_format($number, 0, ',', '.') . ' Đ';
    }
}