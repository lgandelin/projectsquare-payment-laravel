<div class="col-md-6">
    <h3>{{ trans('projectsquare-payment::signup.recap') }}</h3>

    <section>
        <h4>{{ trans('projectsquare-payment::signup.step1_title') }}</h4>

        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.agency_name') }} : </label>
            <span class="value name_value"></span>
        </div>

        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.url') }} : </label>
            <span class="value url">http://<span class="slug_value"></span>
        </div>

        <div class="form-group">
            <label>{{ trans('projectsquare-payment::signup.users_count') }} : </label>
            <span class="value users_count_value"></span>
        </div>
    </section>

    <section>
        <h4>{{ trans('projectsquare-payment::signup.step2_title') }}</h4>

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
    </section>
</div>

<div class="col-md-6">
    <section style="margin-top: 11.5rem;">
        <h4>{{ trans('projectsquare-payment::signup.cost') }}</h4>

        {{--Coût fixe : <span class="amount">{{ number_format($platform_monthly_cost, 2) }}</span>€ / mois<br/>
        Prix / utilisateur : <span class="amount">{{ number_format($user_monthly_cost, 2) }}</span>€ / mois<br/>--}}
        <p><span class="free">Gratuit</span> : du {{ date('d/m/Y') }} au {{ date('d/m/Y', strtotime('+1 month')) }}</p>
        <span class="amount"><span class="total">{{ number_format($total_monthly_cost, 2) }}</span>€</span> / mois à partir du {{ date('d/m/Y', strtotime('+1 month')) }}
    </section>
</div>

<div class="submit" style="clear: both; margin-top: 5rem;">
    <input type="button" class="pull-left back-step-2" value="{{ trans('projectsquare-payment::signup.previous_step') }}" />
    <input type="submit" class="pull-right valid-step-3" value="{{ trans('projectsquare-payment::signup.valid_platform_creation') }}" />
</div>

{{ csrf_field() }}
