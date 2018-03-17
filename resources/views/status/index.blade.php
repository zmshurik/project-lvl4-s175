@extends('layouts.app')

@section('status', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task statuses</div>

                <div class="card-body">
                    <div class="text-center">@include('flash::message')</div>
                    <form action=" {{ route('taskStatuses.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control{{ $errors->has('statusName') ? ' is-invalid' : '' }}" placeholder="Enter new task status" name="statusName" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Add</button>
                        </div>
                        @if ($errors->has('statusName'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('statusName') }}</strong>
                        </span>
                    @endif
                    </div>
                    </form>
                    @if ($errors->has('statusName'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('statusName') }}</strong>
                        </span>
                    @endif
                    <ul class="list-group">
                        @foreach ($taskStatuses as $taskStatus)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $taskStatus->name }}
                                @if($taskStatus->id != 1)
                                <span>
                                    <a class="btn btn-outline-info btn-sm" href="{{ route('taskStatuses.edit', ['id' => $taskStatus->id]) }}">edit</a>                                    
                                    <a class="btn btn-danger btn-sm" data-confirm="Are you sure?" data-method="delete" 
                                    rel="nofollow" href="{{ route('taskStatuses.destroy', ['id' => $taskStatus->id]) }}">delete</a>
                                </span>
                                @endif
                            </li>
                        @endforeach
                        <div class="d-flex justify-content-center">{{ $taskStatuses->links() }}</div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
