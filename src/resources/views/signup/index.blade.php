<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inscription Projectsquare</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
</head>
<body>
    <form action="{{ route('signup_handler') }}" method="post" class="container signup-template">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ trans('projectsquare-payment::signup.title') }}</h1>
            </div>
        </div>

        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <span data-tab="1" class="btn btn-primary btn-circle">1</span>
                    <p>{{ trans('projectsquare-payment::signup.step1_title') }}</p>
                </div>
                <div class="stepwizard-step">
                    <span data-tab="2" class="btn btn-default btn-circle" disabled="disabled">2</span>
                    <p>{{ trans('projectsquare-payment::signup.step2_title') }}</p>
                </div>
                <div class="stepwizard-step">
                    <span data-tab="3" class="btn btn-default btn-circle" disabled="disabled">3</span>
                    <p>{{ trans('projectsquare-payment::signup.step3_title') }}</p>
                </div>
            </div>
        </div>

        @if (isset($error) && $error)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ $error }}
            </div>
        @endif

        <div class="row setup-content" id="step-1">
            @include('projectsquare-payment::signup.steps.step1')
        </div>

        <div class="row setup-content" id="step-2">
            @include('projectsquare-payment::signup.steps.step2')
        </div>

        <div class="row setup-content" id="step-3">
            @include('projectsquare-payment::signup.steps.step3')
        </div>

        <input type="hidden" id="platform_monthly_cost" value="{{ $platform_monthly_cost }}" />
        <input type="hidden" id="user_monthly_cost" value="{{ $user_monthly_cost }}" />
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.min.js"></script>
    <script>var route_check_slug = "{{ route('signup_check_slug') }}";</script>
    <script src="{{ asset('js/signup.js') }}"></script>
</body>
</html>