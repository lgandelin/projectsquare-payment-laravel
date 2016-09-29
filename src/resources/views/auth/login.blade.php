@extends('projectsquare-payment::master')

@section('main-content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-top: 5rem">
                <div class="panel-heading">{{ trans('projectsquare-payment::login.panel_title') }}</div>
                <div class="panel-body">

                    @if (isset($error))
                        <div class="info bg-danger">
                            {{ $error }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login_handler') }}">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('projectsquare-payment::login.email') }}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('projectsquare-payment::login.password') }}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" autocomplete="off" />
                            </div>
                        </div>

                        {{--<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember_token" />{{ trans('projectsquare-payment::login.remember') }}
                                    </label>
                                </div>
                            </div>
                        </div>--}}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn valid">
                                    <i class="fa fa-btn fa-sign-in"></i>{{ trans('projectsquare-payment::login.login') }} <span class="glyphicon glyphicon-log-in" style="margin-left: 1rem"></span>
                                </button>

                                <a class="btn btn-link" href="{{ route('forgotten_password') }}">{{ trans('projectsquare-payment::login.forgotten_password') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
