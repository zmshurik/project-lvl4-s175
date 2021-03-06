<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskStatus;
use PHPUnit\Framework\Exception;

class TaskStatusController extends Controller
{
    const NEW_STATUS_ID = 1;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = TaskStatus::paginate(10);
        return view('status.index', ['taskStatuses' => $statuses]);
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
            'statusName' => 'required|string|max:50|unique:task_statuses,name'
        ]);
        TaskStatus::create(['name' => $request->statusName]);
        flash('Task status added successfuly!')->success()->important();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = TaskStatus::findOrFail($id);
        if ($id == self::NEW_STATUS_ID) {
            flash("You can't edit this status")->error()->important();
            return redirect()->back();
        }
        return view('status.edit', ['taskStatus' => $status]);
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
            'statusName' => 'required|string|max:50|unique:task_statuses,name'
        ]);
        $status = TaskStatus::findOrFail($id);
        if ($id == self::NEW_STATUS_ID) {
            flash("You can't edit this status")->error()->important();
        } else {
            $status->name = $request->statusName;
            $status->save();
            flash('Task status changed successfuly!')->success()->important();
        }
        return redirect()->route('taskStatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = TaskStatus::findOrFail($id);
        if ($id == self::NEW_STATUS_ID || $status->tasks->isNotEmpty()) {
            flash("You can't delete this status")->error()->important();
            flash("This status has tasks. Plese change all of it before delete.")->warning()->important();
        } else {
            $status->delete();
            flash("Task status deleted successfuly")->success()->important();
        }
        return redirect()->back();
    }
}
