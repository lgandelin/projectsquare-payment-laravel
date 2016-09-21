{{--<h3>{{ trans('projectsquare-payment::signup.step2_title') }}</h3>--}}

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="form-group">
        <label for="administrator_email">{{ trans('projectsquare-payment::signup.email') }}</label>
        <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_email') }}"--}} name="administrator_email" value="{{ old('administrator_email') }}" />
    </div>

    <div class="form-group">
        <label for="administrator_password">{{ trans('projectsquare-payment::signup.password') }}</label>
        <input class="form-control required" type="password"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_password') }}"--}} name="administrator_password" value="{{ old('administrator_password') }}" />
    </div>

    <div class="form-group">
        <label for="administrator_last_name">{{ trans('projectsquare-payment::signup.last_name') }}</label>
        <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_last_name') }}"--}} name="administrator_last_name" value="{{ old('administrator_last_name') }}" />
    </div>

    <div class="form-group">
        <label for="administrator_first_name">{{ trans('projectsquare-payment::signup.first_name') }}</label>
        <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_first_name') }}"--}} name="administrator_first_name" value="{{ old('administrator_first_name') }}" />
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="form-group">
        <label for="administrator_billing_address">{{ trans('projectsquare-payment::signup.billing_address') }}</label>
        <textarea rows="5" class="form-control required" name="administrator_billing_address" style="height: 185px">{{ old('administrator_billing_address') }}</textarea>
    </div>

    <div class="form-group">
        <label for="administrator_zipcode">{{ trans('projectsquare-payment::signup.zipcode') }}</label>
        <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_zipcode') }}"--}} name="administrator_zipcode" value="{{ old('administrator_zipcode') }}" />
    </div>

    <div class="form-group">
        <label for="administrator_city">{{ trans('projectsquare-payment::signup.city') }}</label>
        <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_city') }}"--}} name="administrator_city" value="{{ old('administrator_city') }}" />
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit" style="margin-top: 5rem;">
    <input type="button" class="pull-left back-step-1" value="{{ trans('projectsquare-payment::signup.previous_step') }}" />
    <input type="button" class="pull-right valid-step-2" value="{{ trans('projectsquare-payment::signup.next_step') }}" />
</div>
