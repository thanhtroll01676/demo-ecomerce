<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        View::share('categories', $this->makeCategories(Category::orderBy('name', 'ASC')->get()));
    }

    public function makeCategories($categories){
        $newCateArr = [];
        if(count($categories) > 0){
            foreach($categories as $category){
                $newCateArr[$category->parent][] = $category;
            }
        }
        return $newCateArr;
    }
}
