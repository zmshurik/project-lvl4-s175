@extends('layouts.app')

@section('task', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit task</div>

                <div class="card-body">
                    <div class="text-center">@include('flash::message')</div>
                    <form action="{{ route('tasks.update', ['id' => $task->id]) }}" method="post">
                    @csrf
                    @method('PATCH')
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Name</span>
                            </div>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $task->name }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="description">Description:</label>
                        <div class="input-group mb-1">
                            <textarea id="description" class="form-control" name="description">{{ $task->description }}</textarea>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tags</span>
                            </div>
                            <input type="text" class="form-control" placeholder="please enter tags devided by ','" name="tagsStr" value="{{ $task->tags->pluck('name')->implode(', ') }}">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="Creator">Creator</label>
                            </div>
                            <input class="form-control bg-white" type="text" id="Creator" value="{{ $task->creator->name }}" readonly disabled>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="AssignTo">Assigned to</label>
                            </div>
                            <select class="custom-select{{ $task->assignedTo->trashed() ? ' is-invalid' : '' }}" id="AssignTo" name="assignedToId">
                                @if($task->assignedTo->trashed())
                                    <option value="{{ $task->assignedTo->id }}" selected>{{ $task->assignedTo->name }}</option>
                                @endif
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $task->assignedTo->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if($task->assignedTo->trashed())
                                <span class="invalid-feedback">
                                    <strong>This user deleted. Please choose another one!</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="Status">Status</label>
                            </div>
                            <select class="custom-select" id="Status" name="statusId">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $task->status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                          </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success">Change task</button>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-danger" data-confirm="Are you sure?" data-method="delete"
                                 rel="nofollow" href="{{ route('tasks.destroy', ['id' => $task->id]) }}">Delete task</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
