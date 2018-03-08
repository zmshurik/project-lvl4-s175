@extends('layouts.app')

@section('users', 'active')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @csrf
                    <ul class="list-group text-center">
                        @foreach ($users as $user)
                            <li class="list-group-item">{{ $user->name }}</li>
                        @endforeach
                        <div class="d-flex justify-content-center">{{ $users->links() }}</div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
