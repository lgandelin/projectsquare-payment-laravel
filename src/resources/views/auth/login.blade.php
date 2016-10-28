@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_login') }}
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
                        {{ trans('projectsquare-payment::login.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::login.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('projectsquare-payment::login.title') }}</div>
                    <div class="panel-body">

                        @if (isset($error))
                            <div class="info bg-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login_handler') }}">

                            <div class="form-group">
                                <label>{{ trans('projectsquare-payment::login.email') }}</label>
                                <input type="email" class="form-control" name="email" />
                            </div>

                            <div class="form-group">
                                <label>{{ trans('projectsquare-payment::login.password') }}</label>
                                <input type="password" class="form-control" name="password" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="button button-valid">
                                    {{ trans('projectsquare-payment::login.login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('forgotten_password') }}">{{ trans('projectsquare-payment::login.forgotten_password') }}</a>
                            </div>

                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
