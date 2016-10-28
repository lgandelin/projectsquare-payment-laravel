@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_forgotten_password') }}
@endsection

@section('main-content')
    <div class="template login_template">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">{{ trans('projectsquare-payment::pages.home_title') }}</a>
                    </li>
                    <li class="page_fille">
                        {{ trans('projectsquare-payment::forgotten_password.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::forgotten_password.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('projectsquare-payment::forgotten_password.title') }}</div>
                    <div class="panel-body">

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

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('forgotten_password_handler') }}">
                            <div class="form-group">
                                <label>{{ trans('projectsquare-payment::forgotten_password.email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="button button-valid" title="{{ trans('projectsquare-payment::forgotten_password.title_password_forgotten') }}">
                                    {{ trans('projectsquare-payment::forgotten_password.send_new_password') }}
                                </button>

                                <a href="javascript:history.back()" class="btn btn-dark-gray" title="{{ trans('projectsquare-payment::forgotten_password.back_to_login') }}">{{ trans('projectsquare-payment::forgotten_password.back_to_login') }}</a>
                            </div>

                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
