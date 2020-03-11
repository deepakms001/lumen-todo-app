<?php

namespace App\Operations\Category;

use App\Models\Category;

class CreateCategory
{
    public function run(array $fields)
    {
        $category = new Category();
        $category->name = $fields['name'];
        $category->user_id = $fields['user_id'];
        $category->save();
        return $category;
    }
}
