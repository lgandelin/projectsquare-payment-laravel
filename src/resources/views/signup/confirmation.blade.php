@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_signup_confirmation') }}
@endsection

@section('main-content')
    <div class="template signup_confirmation_template ">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">{{ trans('projectsquare-payment::pages.home_title') }}</a>
                    </li>
                    <li class="page_fille">
                        {{ trans('projectsquare-payment::signup_confirmation.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::signup_confirmation.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="thanks">
                    <h3>{{ trans('projectsquare-payment::signup_confirmation.thanks_for_signing_up') }}</h3>

                    <p>{{ trans('projectsquare-payment::signup_confirmation.thanks_for_signing_up2') }}</p>
                </div>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        {{ trans('projectsquare-payment::signup_confirmation.platform_creation_in_progress') }}
                    </div>
                </div>

                <div class="platform-ready" style="display: none;">
                    <a class="button" href="#" target="_blank">{{ trans('projectsquare-payment::signup_confirmation.access_my_platform') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <script>var route_check_platform_url = "{{ route('signup_confirmation_check_platform_url') }}";</script>
    <script src="{{ asset('js/signup_confirmation.js') }}"></script>
@endsection