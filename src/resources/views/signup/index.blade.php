@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_signup') }}
@endsection

@section('main-content')

    <div class="signup-template">

        <div class="signup">
            @include('projectsquare-payment::signup.includes.header')

            @include('projectsquare-payment::signup.includes.simplify')

            @include('projectsquare-payment::signup.includes.features')

            <!-- FOOTER -->
            <div class="footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="blue-wrapper">
                            <a class="start-free-trial button" href="#essai-gratuit">Démarrer mon essai gratuit</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOOTER -->
        </div>

    </div>

    <script>var route_free_trial_handler = "{{ route('landing_free_trial_handler') }}";</script>
    <script src="{{ asset('js/signup.js') }}"></script>
@endsection