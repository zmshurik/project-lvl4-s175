@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @csrf
                    <ul>
                        @foreach ($users as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                        <div class="d-flex justify-content-center">{{ $users->links() }}</div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
