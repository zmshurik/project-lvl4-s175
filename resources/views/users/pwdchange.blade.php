@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change password</div>

                <div class="card-body">
                <div class="text-center">@include('flash::message')</div>
                    <form method="POST" action="{{ route('user.storepwd') }}">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Current password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>

                                @if ($errors->has('old-password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password" class="col-md-4 col-form-label text-md-right">New password</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>

                                @if ($errors->has('new-password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="new-password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
