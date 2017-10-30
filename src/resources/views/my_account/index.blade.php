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

                @if ($subscription)
                    @if ($subscription->onTrial())
                        <p class="form-group"><label>{{ trans('projectsquare-payment::my_account.trial_version_until') }}</label> {{ (new \DateTime($subscription->trial_ends_at))->format('d/m/Y') }}</p>
                    @elseif ($subscription->onGracePeriod())
                        <p class="form-group"><label>{{ trans('projectsquare-payment::my_account.grace_period_until') }}</label> {{ (new \DateTime($subscription->ends_at))->format('d/m/Y') }}</p>
                    @else
                        <p class="form-group"><label>{{ trans('projectsquare-payment::my_account.monthly_usage') }} :</label> <span class="value">{{ number_format($monthly_cost, 2) }}</span>€</p>
                    @endif
                @else
                    <p class="form-group"><label>Pas d'abonnement en cours :</label> <a class="buttn button-valid button-subscribe" href="{{ route('subscribe') }}">Je m'abonne</a></p>
                @endif

                <label for="users_count">{{ trans('projectsquare-payment::my_account.users_number') }} :</label>
                <span class="users-count-display">
                    <span class="value">{{ $users_count }}</span>
                </span>

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
                            <input class="form-control required" type="text" name="administrator_email" value="{{ $user->email }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_password">{{ trans('projectsquare-payment::signup.password') }}</label>
                            <input class="form-control required" type="password" name="administrator_password" value="" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_last_name">{{ trans('projectsquare-payment::signup.last_name') }}</label>
                            <input class="form-control required" type="text" name="administrator_last_name" value="{{ $user->last_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_first_name">{{ trans('projectsquare-payment::signup.first_name') }}</label>
                            <input class="form-control required" type="text" name="administrator_first_name" value="{{ $user->first_name }}" />
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
                            <input class="form-control required" type="text" name="administrator_zipcode" value="{{ $user->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="administrator_city">{{ trans('projectsquare-payment::signup.city') }}</label>
                            <input class="form-control required" type="text" name="administrator_city" value="{{ $user->city }}" />
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
                            <th width="150" align="right">{{ trans('projectsquare-payment::generic.action') }}</th>
                        </tr>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->number }}</td>
                            <td>{{ (new \DateTime())->setTimestamp($invoice->date)->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($invoice->total / 100, 2) }}€ TTC</td>
                            <td>
                                <a href="{{ route('payment_invoice', ['invoice' => $invoice->id]) }}" class="button button-valid">{{ trans('projectsquare-payment::generic.download') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <p>Aucune facture n'est disponible pour le moment.</p>
                @endif

                <hr>
            </section>

            @if ($subscription && !$subscription->onGracePeriod() && !$subscription->onTrial())

                <section class="refund-subscription col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5rem">
                    <h3>Demande de remboursement</h3>
                    <p>ATTENTION ! Demander le remboursement de votre abonnement aura pour effet la suppression totale de votre plateforme et de ses données.</p>

                    <form action="{{ route('refund') }}" method="POST">
                        <input type="submit" class="button button-red" value="Me rembourser" />
                        {{ csrf_field() }}
                    </form>
                </section>

                <hr>

                <section class="cancel-subscription col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5rem">
                    <h3>Annulation de l'abonnement</h3>
                    <p>ATTENTION ! Demander l'annulation de votre abonnement aura pour effet la suppression totale de votre plateforme et de ses données.</p>

                    <form action="{{ route('cancel') }}" method="POST">
                        <input type="submit" class="button button-red" value="Me désinscrire" />
                        {{ csrf_field() }}
                    </form>
                </section>
            @endif

        </div>
    </div>

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection