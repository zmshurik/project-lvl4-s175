@extends('layouts.app')

@section('home', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p class="display-4 text-center">Hello {{ Auth::user()->name }}!</p>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tasks created by You
                            <span class='badge badge-primary'>{{ Auth::user()->createdTasks->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tasks assigned to You
                            <span class='badge badge-primary'>{{ Auth::user()->assignedTasks->count() }}</span>
                        </li>                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            New tasks assigned to you
                            <span class='badge badge-primary'>{{ Auth::user()->assignedTasks->where('status_id', 1)->count() }}</span>
                        </li>
                    </ul>                    
                    <a class="btn btn-outline-info btn-sm" href="{{ route('tasks.index') }}">Check it</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
