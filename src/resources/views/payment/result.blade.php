@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::payment.title') }}
@endsection

@section('main-content')
    <div class="template my_account_template">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">{{ trans('projectsquare-payment::pages.home_title') }}</a>
                    </li>
                    <li class="page_fille">
                        {{ trans('projectsquare-payment::payment.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">
                    @if ($status == 4)
                        {{ trans('projectsquare-payment::payment.payment_cancelled_title') }}
                    @elseif ($status == 3)
                        {{ trans('projectsquare-payment::payment.payment_error_title') }}
                    @elseif ($status == 2)
                        {{ trans('projectsquare-payment::payment.payment_success_title') }}
                    @else
                        {{ trans('projectsquare-payment::payment.payment_in_progress_title') }}
                    @endif
                </h1>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                @if ($status == 4)
                    <p>{{ trans('projectsquare-payment::payment.payment_cancelled_text') }}</p>
                @elseif ($status == 3)

                    <p>{{ trans('projectsquare-payment::payment.payment_error_text') }}</p>

                    <p>{{ trans('projectsquare-payment::payment.payment_error_text_info') }}</p>
                @elseif ($status == 2)
                    <p>{{ trans('projectsquare-payment::payment.payment_success_text') }}</p>

                    <p>{{ trans('projectsquare-payment::payment.payment_success_text_info') }}</p>
                @else
                    <p></p>{{ trans('projectsquare-payment::payment.payment_in_progress_text') }}</p>
                @endif

                <a class="btn btn-primary" href="{{ route('my_account') }}">{{ trans('projectsquare-payment::payment.back_to_my_account') }}</a>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script>var route_payment_form = "{{ route('payment_form') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection