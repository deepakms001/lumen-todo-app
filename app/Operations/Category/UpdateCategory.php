<?php

namespace App\Operations\Category;


class UpdateCategory
{
    public function run($category, $attributes)
    {
        $category->name = $attributes['name'];
        if ($category->save()) {
            return $category;
        }
        return false;
    }
}
