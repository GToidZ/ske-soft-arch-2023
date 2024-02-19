<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Singletons\FacebookConnector;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $req) {
        $tasks = Task::where('user_id', $req->user()->id)->get();

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $req) {
        $this->validate($req, [
            'name' => 'required|max:200'
        ]);

        $req->user()->tasks()->create([
            'name' => $req->name
        ]);

        return redirect('/tasks');
    }

    public function publishToFB(Request $req, string $taskId) {
        $task = Task::whereId($taskId)->first();
        if (!$task) {
            abort(404);
        }

        $fbConnector = FacebookConnector::getInstance();
        if (!$fbConnector->isLoggedIn()) {
            return redirect(FacebookConnector::buildAuthURL(csrf_token()));
        }

        return $fbConnector->post($task);
    }
}
