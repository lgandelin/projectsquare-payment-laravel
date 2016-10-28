@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_my_account') }}
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
                        {{ trans('projectsquare-payment::my_account.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::my_account.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-section">
                <a href="{{ route('logout') }}" class="button btn-logout">{{ trans('projectsquare-payment::my_account.disconnect') }}</a>

                <h3>{{ trans('projectsquare-payment::my_account.platform') }}</h3>


                <label for="users_count">{{ trans('projectsquare-payment::my_account.users_number') }} :</label>
                <span class="users-count-display">
                    <span class="value" style="font-size:3.5rem; display: inline-block; vertical-align: middle; margin-right: 1rem;">{{ $users_count }}</span> <input type="button" class="button btn-users-count" value="{{ trans('projectsquare-payment::generic.modify') }}" />
                </span>

                <span class="users-count-update" style="display: none">
                    <input class="form-control" type="number" value="{{ $users_count }}" name="users_count" style="display: inline-block; width: 75px" />
                    <input type="button" class="button button-valid btn-valid-users-count-update" value="{{ trans('projectsquare-payment::generic.valid') }}" />
                    <input type="button" class="button btn-valid-users-count-cancel" value="{{ trans('projectsquare-payment::generic.cancel') }}" />
                </span>
                <hr>
            </section>

            <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>{{ trans('projectsquare-payment::my_account.account') }}</h3>

                <p><label for="">{{ trans('projectsquare-payment::my_account.account_balance') }} :</label> <span style="font-size:3.5rem;">{{ number_format($balance, 2) }}€</span></p>
                <p class="daily-usage">{{ trans('projectsquare-payment::my_account.daily_usage') }} : <span class="value">{{ number_format($daily_cost, 2) }}</span>€</p>
                <p class="monthly-usage">{{ trans('projectsquare-payment::my_account.monthly_usage') }} : <span class="value">{{ number_format($monthly_cost, 2) }}</span>€</p>

                <input type="text" class="form-control amount" name="amount" style="width:100px; display: inline-block;" placeholder="ex: 50.00" /> €
                <input type="button" class="button button-valid btn-valid-fund-account" value="{{ trans('projectsquare-payment::my_account.refund') }}" />

                <form id="payment-form" method="post" action="{{ env('MERCANET_PAYMENT_URL') }}">
                    <input type="hidden" name="Data" value="">
                    <input type="hidden" name="InterfaceVersion" value="{{ env('MERCANET_VERSION') }}">
                    <input type="hidden" name="Seal" value="">
                </form>

                <p style="display: none;">
                    <input type="checkbox" name="email_alert" /> M'envoyer un email lorsque le solde du compte est inférieur à <input class="form-control" type="text" value="20" style="display: inline-block; width: 50px"/> €
                    <input type="button" class="button button-valid button-valid-information" value="Valider" />
                </p>
                <hr>
            </section>

            <section>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3>{{ trans('projectsquare-payment::my_account.my_data') }}</h3>

                    @if (isset($error))
                        <div class="info bg-danger">
                            {{ $error }}
                        </div>
                    @endif

                    @if (isset($confirmation))
                        <div class="info bg-success">
                            {{ $confirmation }}
                        </div>
                    @endif
                </div>

                <form action="{{ route('update_administrator') }}" method="post">

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="administrator_email">{{ trans('projectsquare-payment::signup.email') }}</label>
                            <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_email') }}"--}} name="administrator_email" value="{{ $user->email }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_password">{{ trans('projectsquare-payment::signup.password') }}</label>
                            <input class="form-control required" type="password"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_password') }}"--}} name="administrator_password" value="" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_last_name">{{ trans('projectsquare-payment::signup.last_name') }}</label>
                            <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_last_name') }}"--}} name="administrator_last_name" value="{{ $user->last_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_first_name">{{ trans('projectsquare-payment::signup.first_name') }}</label>
                            <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_first_name') }}"--}} name="administrator_first_name" value="{{ $user->first_name }}" />
                        </div>

                        <input type="submit" class="button button-valid" value="{{ trans('projectsquare-payment::generic.valid') }}" />
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="administrator_billing_address">{{ trans('projectsquare-payment::signup.billing_address') }}</label>
                            <textarea rows="5" class="form-control required" name="administrator_billing_address" style="height: 113px">{{ $user->billing_address }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="administrator_zipcode">{{ trans('projectsquare-payment::signup.zipcode') }}</label>
                            <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_zipcode') }}"--}} name="administrator_zipcode" value="{{ $user->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_city">{{ trans('projectsquare-payment::signup.city') }}</label>
                            <input class="form-control required" type="text"{{-- placeholder="{{ trans('projectsquare-payment::signup.placeholder_city') }}"--}} name="administrator_city" value="{{ $user->city }}" />
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    {{ csrf_field() }}
                </form>
                <hr>
            </section>

            <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <h3>{{ trans('projectsquare-payment::my_account.billing_history') }}</h3>

                @if ($invoices)
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ trans('projectsquare-payment::my_account.bill_identifier') }}</th>
                            <th>{{ trans('projectsquare-payment::my_account.bill_date') }}</th>
                            <th>{{ trans('projectsquare-payment::my_account.bill_amount') }}</th>
                            <th>{{ trans('projectsquare-payment::my_account.bill_payment_mean') }}</th>
                            <th width="260" align="right">{{ trans('projectsquare-payment::generic.action') }}</th>
                        </tr>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->identifier }}</td>
                            <td>{{ $invoice->creation_date }}</td>
                            <td>{{ number_format($invoice->amount, 2) }}€ TTC</td>
                            <td>{{ $invoice->payment_mean }}</td>
                            <td>
                                <a href="{{ route('invoice', ['invoice_identifier' => $invoice->identifier, 'download' => false]) }}" target="_blank" class="button">{{ trans('projectsquare-payment::generic.see') }}</a>
                                <a href="{{ route('invoice', ['invoice_identifier' => $invoice->identifier, 'download' => true]) }}" class="button button-valid">{{ trans('projectsquare-payment::generic.download') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @endif

                {{--
                    <hr>
                    <h3>Se désinscrire</h3>
                    <input type="button" class="btn btn-danger" value="Se désinscrire" />
                --}}

            </section>
        </div>
    </div>

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script>var route_payment_form = "{{ route('payment_form') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection