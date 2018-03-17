@extends('layouts.app')

@section('status', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task statuses</div>

                <div class="card-body">
                    <form action="taskStatuses.store" method="post"></form>
                    <ul class="list-group">
                        @foreach ($taskStatuses as $taskStatus)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $taskStatus->name }} 
                                <span>
                                    <a class="btn btn-outline-info btn-sm" href="#">edit</a>
                                    <a class="btn btn-danger btn-sm" href="#">delete</a>
                                </span>
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
