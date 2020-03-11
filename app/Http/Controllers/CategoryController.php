<?php


namespace App\Http\Controllers;

use App\Features\CreateCategoryFeature;
use App\Features\GetCategoryFeature;
use App\Features\ListCategoryFeature;
use App\Features\UpdateCategoryFeature;
use App\Features\DeleteCategoryFeature;

use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        return (new CreateCategoryFeature())->run($this->request);
    }


    public function get($categoryId)
    {
        return (new GetCategoryFeature())->run($this->request, $categoryId);
    }

    public function list()
    {
        return (new ListCategoryFeature())->run($this->request);
    }

    public function update($categoryId)
    {
        return (new UpdateCategoryFeature())->run($this->request, $categoryId);
    }

    public function delete($categoryId)
    {
        return (new DeleteCategoryFeature())->run($this->request, $categoryId);
    }
}
