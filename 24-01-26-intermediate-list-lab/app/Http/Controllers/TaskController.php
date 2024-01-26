<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

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
}
