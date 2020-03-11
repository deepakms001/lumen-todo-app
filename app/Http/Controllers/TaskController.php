<?php


namespace App\Http\Controllers;

use App\Features\CreateTaskFeature;
use App\Features\GetTaskFeature;
use App\Features\ListTaskFeature;
use App\Features\UpdateTaskFeature;
use App\Features\DeleteTaskFeature;

use Illuminate\Http\Request;

class TaskController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        return (new CreateTaskFeature())->run($this->request);
    }

    public function get($taskId)
    {
        return (new GetTaskFeature())->run($this->request, $taskId);
    }

    public function list()
    {
        return (new ListTaskFeature())->run($this->request);
    }

    public function update($taskId)
    {
        return (new UpdateTaskFeature())->run($this->request, $taskId);
    }

    public function delete($taskId)
    {
        return (new DeleteTaskFeature())->run($this->request, $taskId);
    }
}
