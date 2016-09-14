<div class="col-lg-12 col-md-12">
    <h3 style="margin-bottom: 3rem;">{{ trans('projectsquare-payment::signup.step3_title') }}</h3>

    <h4>{{ trans('projectsquare-payment::signup.step1_title') }}</h4><br>

    <div class="col-md-6">

        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.agency_name') }} : </label>
            <span class="value agency_name_value"></span>
        </div>

        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.url') }} : </label>
            <span class="value url_value"></span>
        </div>


        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.users_count') }} : </label>
            <span class="value users_count_value"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group col-lg-6 col-md-6">
            <label>{{ trans('projectsquare-payment::signup.platform_cost') }}</label><br/>
            Coût fixe : <span class="amount">27.00</span>€ / mois<br/>
            Prix / utilisateur : <span class="amount">17.00</span>€ / mois<br/>
            <span class="amount total">44.00</span>€ / mois
        </div>
    </div>

    <hr style="clear:both">

    <h4>{{ trans('projectsquare-payment::signup.step2_title') }}</h4><br>

    <div class="form-group">
        <label>{{ trans('projectsquare-payment::signup.email') }} : </label>
        <span class="value administrator_email_value"></span>
    </div>

    <div class="form-group">
        <label>{{ trans('projectsquare-payment::signup.password') }} : </label>
        * * * * *
    </div>

    <div class="form-group">
        <label>{{ trans('projectsquare-payment::signup.last_name') }} : </label>
        <span class="value administrator_last_name_value"></span>
    </div>

    <div class="form-group">
        <label>{{ trans('projectsquare-payment::signup.first_name') }} : </label>
        <span class="value administrator_first_name_value"></span>
    </div>

    <div class="form-group">
        <label for="administrator_billing_address">{{ trans('projectsquare-payment::signup.billing_address') }} : </label>
        <span class="value administrator_billing_address_value"></span>
    </div>

    <div class="form-group">
        <label for="administrator_zipcode">{{ trans('projectsquare-payment::signup.zipcode') }} : </label>
        <span class="value administrator_zipcode_value"></span>
    </div>

    <div class="form-group">
        <label for="administrator_city">{{ trans('projectsquare-payment::signup.city') }} : </label>
        <span class="value administrator_city_value"></span>
    </div>

    <div class="submit" style="margin-top: 5rem;">
        <input type="button" class="btn btn-default pull-left back-step-2" value="{{ trans('projectsquare-payment::signup.previous_step') }}" />
        <input type="button" class="btn btn-success pull-right valid-step-3" value="{{ trans('projectsquare-payment::signup.valid_platform_creation') }}" />
    </div>
</div>