<div class="col-lg-12 col-md-12">
    <h3>{{ trans('projectsquare-payment::signup.step1_title') }}</h3>

    <div style="margin-bottom: 4rem; clear: both;">
        <div class="form-group">
            <label for="name">{{ trans('projectsquare-payment::signup.agency_name') }}</label>
            <input class="form-control required" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_agency_name') }}" name="name" value="{{ old('name') }}" style="width: 50%" />
        </div>
    </div>

    <hr>

    <div style="margin-bottom: 4rem; clear: both;">
        <div class="form-group">
            <label for="slug">{{ trans('projectsquare-payment::signup.url') }}</label><br>

            <div class="notice" style="font-style: italic;">
                <p>
                    {{ trans('projectsquare-payment::signup.url_notice') }}<br/>
                    {{ trans('projectsquare-payment::signup.url_notice_2') }}<br/>
                </p>
            </div>

            <input class="form-control required" type="text" placeholder="{{ trans('projectsquare-payment::signup.placeholder_url') }}" name="slug" value="{{ old('slug') }}" style="display: inline-block; width: 400px"/>
            .projectsquare.io
            <input type="button" class="btn btn-sm btn-primary check-slug-btn" value="{{ trans('projectsquare-payment::signup.check_slug') }}" style="margin-left: 2rem;" />
        </div>
    </div>

    <hr>

    <div style="margin-bottom: 4rem; clear: both;">
        <div class="form-group col-lg-6 col-md-6">
            <label for="users_count">{{ trans('projectsquare-payment::signup.users_count') }}</label>
            <div style="margin-top: 2.5rem; margin-left: 1rem; cursor: pointer;">
                <input id="slider_users_count" data-slider-id='slider_users_count' type="text" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="{{ $users_count }}"/>
                <input class="form-control" type="number" name="users_count" value="{{ $users_count }}" style="display: inline-block; width: 50px; margin-left: 5rem; margin-right: 0.5rem; padding-right: 0; text-align: center" readonly /> {{ trans('projectsquare-payment::signup.users') }}
            </div>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            <label>{{ trans('projectsquare-payment::signup.platform_cost') }}</label><br/>
            Coût fixe : <span class="amount">{{ number_format($platform_monthly_cost, 2) }}</span>€ / mois<br/>
            Prix / utilisateur : <span class="amount">{{ number_format($user_monthly_cost, 2) }}</span>€ / mois<br/>
            <span class="amount total">{{ number_format($total_monthly_cost, 2) }}</span>€ / mois
        </div>
    </div>

    <div style="clear:both">
        <input type="button" class="btn btn-success pull-right valid-step-1" value="{{ trans('projectsquare-payment::signup.next_step') }}" />
    </div>
</div>