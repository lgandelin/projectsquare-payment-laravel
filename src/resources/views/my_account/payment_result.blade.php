@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::my_account.payment_result') }}
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
                        {{ trans('projectsquare-payment::my_account.payment_result') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::my_account.payment_result') }}</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <br>
                <a style="float: right" href="{{ route('logout') }}">Se déconnecter</a>

                Votre paiement a été effectué avec succès !
            </div>
        </div>
    </div>
    {{ csrf_field() }}

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script>var route_payment_form = "{{ route('payment_form') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection