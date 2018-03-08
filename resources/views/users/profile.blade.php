@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile settings</div>

                <div class="card-body">
                    <div class="text-center">@include('flash::message')</div>
                    <form class="mb-4" action="{{ route('user.save') }}" method="POST">
                        {{ method_field('PATCH') }}
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
                    <form action="/user/profile" method="post">
                        {{ method_field('DELETE') }}
                        @csrf
                        <!-- Button trigger modal -->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation">
                              Delete account
                            </button>
                        </div>                        

                        <!-- Modal -->
                        <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-dark bg-warning d-flex justify-content-center">
                                <h5 class="modal-title" id="exampleModalLongTitle">Confirm deletion</h5>                                
                              </div>
                              <div class="modal-body text-center">
                                Are you sure that you want to delete the account forever. You can't restore it in the future.
                              </div>
                              <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">DELETE</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
