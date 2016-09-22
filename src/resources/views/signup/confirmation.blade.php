@extends('projectsquare-payment::master')

@section('page-title')
    Inscription à Projectsquare confirmée !
@endsection

@section('main-content')
    <div class="template confirmation_template">
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
                <p>Merci de vous être inscrits à Projectsquare !</p>

                <p>Votre plateforme est en cours de création, vous recevrez un email lorsque celle-ci sera prête.</p>

                <p>En cas de problème, n'hésitez pas à nous contacter.</p>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <script>var route_check_platform_url = "{{ route('signup_confirmation_check_platform_url') }}";</script>
    <script src="{{ asset('js/signup_confirmation.js') }}"></script>
@endsection