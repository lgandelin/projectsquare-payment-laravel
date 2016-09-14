<div class="col-lg-12 col-md-12">
    <h3 style="margin-bottom: 3rem;">{{ trans('projectsquare-payment::signup.step2_title') }}</h3>

    <div class="form-group">
        <label for="administrator_email">{{ trans('projectsquare-payment::signup.email') }}</label>
        <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_email') }}" name="administrator_email" style="width: 50%" />
    </div>

    <div class="form-group">
        <label for="administrator_password">{{ trans('projectsquare-payment::signup.password') }}</label>
        <input class="form-control" type="password" placeholder="{{ trans('projectsquare-payment::signup.placeholder_password') }}" name="administrator_password" style="width: 50%" />
    </div>

    <div class="form-group">
        <label for="administrator_last_name">{{ trans('projectsquare-payment::signup.last_name') }}</label>
        <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_last_name') }}" name="administrator_last_name" style="width: 50%" />
    </div>

    <div class="form-group">
        <label for="administrator_first_name">{{ trans('projectsquare-payment::signup.first_name') }}</label>
        <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_first_name') }}" name="administrator_first_name" style="width: 50%" />
    </div>

    <hr>

    <div class="form-group">
        <label for="administrator_billing_address">{{ trans('projectsquare-payment::signup.billing_address') }}</label>
        <textarea rows="5" class="form-control" name="administrator_billing_address" style="width: 50%"></textarea>
    </div>

    <div class="form-group">
        <label for="administrator_zipcode">{{ trans('projectsquare-payment::signup.zipcode') }}</label>
        <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_zipcode') }}" name="administrator_zipcode" style="width: 50%" />
    </div>

    <div class="form-group">
        <label for="administrator_city">{{ trans('projectsquare-payment::signup.city') }}</label>
        <input class="form-control" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_city') }}" name="administrator_city" style="width: 50%" />
    </div>

    <input type="button" class="btn btn-success pull-right valid-step-2" value="{{ trans('projectsquare-payment::signup.next_step') }}" />
</div>