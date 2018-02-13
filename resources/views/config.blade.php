@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>{{ __('messages.config') }}</h1>
                <hr>

                <div class="panel panel-default panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ __('messages.changePass') }}</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('cambiar.pass') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="oldPass">{{ __('messages.oldPass') }}</label>
                                <input type="password" name="oldPass" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="newPass1">{{ __('messages.newPass') }}</label>
                                <input type="password" name="newPass1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="newPass2">{{ __('messages.confirmPass') }}</label>
                                <input type="password" name="newPass2" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{ __('messages.save') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
