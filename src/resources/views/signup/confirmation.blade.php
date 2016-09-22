@extends('projectsquare-payment::master')

@section('page-title')
    Inscription à Projectsquare confirmée !
@endsection

@section('main-content')
    <div class="template signup_confirmation_template ">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">Accueil</a>
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
                    <h3>Merci de vous être inscrits à Projectsquare !</h3>

                    <p>Votre plateforme est en cours de création, vous recevrez un email lorsque celle-ci sera prête.</p>
                </div>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        Création de la plateforme en cours
                    </div>
                </div>

                <div class="platform-ready" style="display: none;">
                    <a class="button" href="#" target="_blank">Accéder à ma plateforme</a>
                </div>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <script>var route_check_platform_url = "{{ route('signup_confirmation_check_platform_url') }}";</script>
    <script src="{{ asset('js/signup_confirmation.js') }}"></script>
@endsection