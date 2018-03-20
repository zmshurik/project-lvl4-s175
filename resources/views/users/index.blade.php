@extends('layouts.app')

@section('users', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <ul class="list-group text-center">
                        @foreach ($users as $user)
                            <li class="list-group-item">{{ $user->name }}</li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-center">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
