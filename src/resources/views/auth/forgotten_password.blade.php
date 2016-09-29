@extends('projectsquare-payment::master')

@section('main-content')
    <div class="container main-content forgotten-password-template">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('projectsquare-payment::forgotten_password.panel_title') }}</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('forgotten_password_handler') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('projectsquare-payment::forgotten_password.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn valid" title="{{ trans('projectsquare-payment::forgotten_password.title_password_forgotten') }}">
                                        {{ trans('projectsquare-payment::forgotten_password.send_new_password') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($message)
                            <div class="info bg-info">
                                {{ $message }}
                            </div>
                        @endif

                        @if ($error)
                            <div class="info bg-danger">
                                {{ $error }}
                            </div>
                        @endif
                    </div>
                </div>

                <a style="display: inline-block; margin: 30px 0" href="javascript:history.back()" class="btn btn-dark-gray" title="{{ trans('projectsquare-payment::forgotten_password.back_to_login') }}">{{ trans('projectsquare-payment::forgotten_password.back_to_login') }}</a>
            </div>
        </div>
    </div>
@endsection
