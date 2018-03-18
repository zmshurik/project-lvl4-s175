@extends('layouts.app')

@section('status', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task statuses</div>

                <div class="card-body">
                    <form action=" {{ route('taskStatuses.update', ['id' => $taskStatus->id]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control{{ $errors->has('statusName') ? ' is-invalid' : '' }}" value="{{ $taskStatus->name }}" name="statusName" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Save</button>
                        </div>
                        @if ($errors->has('statusName'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('statusName') }}</strong>
                            </span>
                        @endif
                    </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
