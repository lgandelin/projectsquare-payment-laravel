{{--<h3>{{ trans('projectsquare-payment::signup.step1_title') }}</h3>--}}

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 left-column">
    <div class="form-group agency">
        <label for="name">{{ trans('projectsquare-payment::signup.agency_name') }}</label>
        <input class="form-control required" type="text" {{--placeholder="{{ trans('projectsquare-payment::signup.placeholder_agency_name') }}"--}} name="name" value="{{ old('name') }}" />
    </div>

    <div class="form-group slug">
        <label for="slug">{{ trans('projectsquare-payment::signup.url') }}</label><br>

        <input data-verified="0" class="form-control required" type="text" {{--placeholder="{{ trans('projectsquare-payment::signup.placeholder_url') }}"--}} name="slug" value="{{ old('slug') }}" style="display: inline-block"/>
        <span class="domain">.projectsquare.io</span>
        <input type="button" class="check-slug-btn" value="{{ trans('projectsquare-payment::signup.check_slug') }}" />

        <div class="notice">
            {{ trans('projectsquare-payment::signup.url_notice') }}<br/><br/>
            {{ trans('projectsquare-payment::signup.url_notice_2') }}<br/>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 right-column">
    <div class="form-group">
        <label for="users_count">{{ trans('projectsquare-payment::signup.users_count') }}</label>

        <span class="users_count">{{ $users_count }}</span>
        <input id="slider_users_count" data-slider-id='slider_users_count' type="text" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="{{ $users_count }}"/>
        <input type="hidden" name="users_count" value="{{ $users_count }}" />
        <br/>
        soit : <span class="amount" style="margin-left: 10px"><span class="total">{{ $total_monthly_cost }}</span>€ / mois</span>
    </div>

    {{--<div class="form-group">
        <label>{{ trans('projectsquare-payment::signup.platform_cost') }}</label><br/>
        Coût fixe : <span class="amount">{{ number_format($platform_monthly_cost, 2) }}</span>€ / mois<br/>
        Prix / utilisateur : <span class="amount">{{ number_format($user_monthly_cost, 2) }}</span>€ / mois<br/>
    </div>--}}

    <div style="clear:both; margin-top: 15rem;">
        <input type="button" class="button valid-step-1" value="{{ trans('projectsquare-payment::signup.next_step') }}" />
    </div>
</div>