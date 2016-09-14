<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inscription Projectsquare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/css/bootstrap-slider.min.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 style="margin-bottom: 3rem;">{{ trans('projectsquare-payment::signup.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 col-md-6" style="margin-bottom: 4rem">
                <label for="agency_name">{{ trans('projectsquare-payment::signup.agency_name') }}</label>
                <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_agency_name') }}" name="agency_name" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 col-md-6" style="margin-bottom: 4rem">
                <label for="url">{{ trans('projectsquare-payment::signup.url') }}</label><br>

                <div class="notice" style="font-style: italic;">
                    <p>
                        {{ trans('projectsquare-payment::signup.url_notice') }}<br/>
                        {{ trans('projectsquare-payment::signup.url_notice_2') }}<br/>
                    </p>
                </div>
                
                <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_url') }}" name="url" style="display: inline-block; width: 400px"/>
                .projectsquare.io
                <input type="button" class="btn btn-sm btn-primary" value="{{ trans('projectsquare-payment::signup.check_url_disponibility') }}" style="margin-top: 1rem;" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 col-md-6" style="margin-bottom: 4rem">
                <label for="url">{{ trans('projectsquare-payment::signup.users_count') }}</label>
                <div style="margin-top: 2.5rem; margin-left: 1rem; cursor: pointer;">
                    <input id="slider_users_count" data-slider-id='slider_users_count' type="text" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1"/>
                    <input class="form-control" type="number" name="users_count" value="1" style="display: inline-block; width: 50px; margin-left: 5rem; margin-right: 0.5rem; padding-right: 0; text-align: center" readonly /> utilisateur(s)
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <input type="button" class="btn btn-success" value="{{ trans('projectsquare-payment::generic.valid') }}" />
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var slider = $("#slider_users_count").slider({
                tooltip: 'always'
            });

            $("#slider_users_count").on("slide", function(slideEvt) {
                $('input[name="users_count"]').val(slideEvt.value);
            });
        });
    </script>
</body>
</html>