<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends ApiController
{

    public function show($id)
    {
        $return = false;
        $categories = \Config::get('categories.list');
        foreach($categories as $category) {
            if($category['id'] == $id) {
                $return = $category;
                break;
            }
        }

        if(!$return) {
            return response()->api()->errorNotFound('Category not found');
        }

        return response()->json($return);
    }

}
