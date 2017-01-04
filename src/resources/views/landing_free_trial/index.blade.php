<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ trans('projectsquare-payment::pages.seo_title_landing_free_trial') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
</head>
<body>
    <div class="landing-free-trial-template container">

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

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="green-wrapper">
                            <span class="copyright">&copy; 2016</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOOTER -->
        </div>

        <script>var route_free_trial_handler = "{{ route('landing_free_trial_handler') }}";</script>
        <script src="{{ asset('js/signup.js') }}"></script>

        @include('projectsquare-payment::includes.ga_tracker')
    </div>

</body>
</html>