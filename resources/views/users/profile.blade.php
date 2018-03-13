@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile settings</div>

                <div class="card-body">
                    <div class="text-center">@include('flash::message')</div>
                    <form class="mb-4" action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="input-group mb-3">
                            <label for="name" class="input-group-text bg-info text-white">Name</label>

                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="input-group mb-3">
                            <label for="email" class="input-group-text bg-info text-white">E-Mail Address</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="mb-3"><a class="btn btn-info" href="{{ route('user.changepwd')}}">Change password</a></div>
                        <div class="d-flex justify-content-center"><button type="submit" class="btn btn-success">Save changes</button></div>
                    </form>
                    <form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="post" data-confirm="Are you sure you want to submit?">
                        @method('DELETE')
                        @csrf

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger">
                              Delete account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
