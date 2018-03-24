<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use App\TaskStatus;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\Exceptions\TooLongTagNameException;
use App\Rules\TagNameLength;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Return array of tags ids from given string
     *
     * @param  string  $tagsStr
     * @return Array
     */
    private function getTagsIdsFromStr($tagsStr)
    {
        $tagNames = collect(explode(',', $tagsStr));
        return $tagNames->map(function ($item, $key) {
            $tagName = trim($item);
            return $tagName;
        })->unique()->reject(function ($name) {
            return empty($name);
        })->map(function ($tagName, $key) {
            return Tag::firstOrCreate(['name' => strtolower($tagName)])->id;
        })->toArray();
    }

    /**
     * Return return parameter or empty string if parameter is null
     *
     * @param  string  $tagsStr
     * @return string
     */
    private function getValidTagsStr($fieldContent)
    {
        return is_null($fieldContent) ? '' : $fieldContent;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        $users = User::has('AssignedTasks')->get();
        $tags = Tag::has('tasks')->get();
        $statuses = TaskStatus::has('tasks')->get();
        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users,
            'tags' => $tags,
            'statuses' => $statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('tasks.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60',
            'tagsStr' => [new TagNameLength]
        ]);
        $tagsStr = $this->getValidTagsStr($request->tagsStr);
        $tagsIds = $this->getTagsIdsFromStr($tagsStr);
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status()->associate(TaskStatus::find(TaskStatusController::NEW_STATUS_ID));
        $task->creator()->associate(Auth::user());
        $task->assignedTo()->associate(User::find($request->assignedToId));
        $task->save();
        $task->tags()->attach($tagsIds);
        flash('Task created successfuly')->success()->important();
        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', ['task' => $task, 'users' => User::all(), 'statuses' => TaskStatus::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:60',
            'tagsStr' => [new TagNameLength]
        ]);
        $assignedUser = User::withTrashed()->find($request->assignedToId);
        $tagsStr = $this->getValidTagsStr($request->tagsStr);
        $tagsIds = $this->getTagsIdsFromStr($tagsStr);
        if ($assignedUser->trashed()) {
            flash('User, on which assigned task, deleted. Please choose another one!')->error();
        } else {
            $task = Task::findOrFail($id);
            $task->name = $request->name;
            $task->description = $request->description;
            $task->status()->associate(TaskStatus::find($request->statusId));
            $task->assignedTo()->associate($assignedUser);
            $task->save();
            $task->tags()->sync($tagsIds);
            flash('Task changed successfuly')->success()->important();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->tags()->detach();
        $task->delete();
        flash('Task deleted successfuly')->success()->important();
        return redirect()->route('tasks.index');
    }
}
