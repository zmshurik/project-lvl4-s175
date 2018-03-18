@extends('layouts.app')

@section('task', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    <div class="text-center">@include('flash::message')</div>
                    <form action="#" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control{{ $errors->has('statusName') ? ' is-invalid' : '' }}"
                             placeholder="Filter will be here" name="statusName" value="{{ old('statusName') }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button">Add</button>
                        </div>
                        @if ($errors->has('statusName'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('statusName') }}</strong>
                            </span>
                        @endif
                    </div>
                    </form>
                    <a class="btn btn-light mb-1" href="{{ route('tasks.create') }}">Create new task</a>
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Creator</th>
                                <th scope="col">Assigned to</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->creator->name }}</td>
                                    <td>{{ $task->assignedTo->name }}</td>
                                    <td>{{ $task->status->name }}</td>
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
