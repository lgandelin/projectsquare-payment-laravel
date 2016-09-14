<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inscription Projectsquare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Logo Projectsquare

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
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 col-md-6" style="margin-bottom: 4rem">
                <label for="url">{{ trans('projectsquare-payment::signup.users_count') }}</label><br>
                <input class="form-control" type="number" placeholder="{{ trans('projectsquare-payment::signup.placeholder_users_count') }}" name="users_count" value="1" style="width: 75px"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <input type="button" class="btn btn-success" value="{{ trans('projectsquare-payment::generic.valid') }}" />
            </div>
        </div>
    </div>
</body>
</html>