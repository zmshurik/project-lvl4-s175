<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use App\Tag;
use App\TaskStatus;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = Task::with(['tags', 'creator', 'assignedTo'])->createdByAuthUser($request->isMyTask)->
            withStatus($request->statusId)->assignedToUser($request->assignedToId)->withTag($request->tagId);
        $users = User::has('AssignedTasks')->get();
        $tags = Tag::has('tasks')->get();
        $statuses = TaskStatus::has('tasks')->get();
        if ($tasks->get()->isEmpty()) {
            flash('No records found')->warning()->important();
        }
        return view('tasks.index', [
            'tasks' => $tasks->paginate(10),
            'users' => $users,
            'tags' => $tags,
            'statuses' => $statuses
        ]);
    }
}
