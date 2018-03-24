@extends('layouts.app')

@section('task', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    <form class="mb-2" action="{{ route('tasks.index') }}" method="GET">                   
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Status</label>
                                <select class="custom-select" name="statusId">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Assigned user</label>
                                <select class="custom-select" name="assignedToId">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tag</label>
                                <select class="custom-select" name="tagId">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="isMyTask">
                                    <label class="form-check-label">Created by me</label>
                                </div>
                            </div>
                            <div class="form-group col-md-3 d-flex justify-content-around">
                                <button type="submit" class="btn btn-outline-success">Search</button>
                                <a class="btn btn-outline-success" href="{{ route('tasks.index') }}">Show all</a>
                            </div>
                        </div>
                    </form>
                    <p>{{ var_dump(1) }}</p>
                    <div class="text-center">@include('flash::message')</div>
                    <a class="btn btn-light mb-1" href="{{ route('tasks.create') }}">Create new task</a>
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Creator</th>
                                <th scope="col">Assigned to</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tags</th>
                                <th class="col-md-1" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->creator->name }}</td>
                                    <td>{{ $task->assignedTo->name }}</td>
                                    <td>{{ $task->status->name }}</td>
                                    <td>{{ $task->tags->pluck('name')->implode(', ') }}</td>
                                    <td>
                                        <span class="d-flex justify-content-end">
                                            <a class="btn btn-outline-info btn-sm" href="{{ route('tasks.edit', ['id' => $task->id]) }}">show</a>
                                            <a class="btn btn-danger btn-sm" data-confirm="Are you sure?" data-method="delete"
                                            rel="nofollow" href="{{ route('tasks.destroy', ['id' => $task->id]) }}">delete</a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">{{ $tasks->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
