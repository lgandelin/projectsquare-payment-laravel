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

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <br>
                <a style="float: right" href="{{ route('logout') }}">Se déconnecter</a>

                <h3>Plateforme</h3>

                <p>
                    <label for="users_count">Nombre d'utilisateurs : </label>
                    <span class="users-count-display">
                        <span class="value" style="font-size:3.5rem; display: inline-block; vertical-align: middle; margin-right: 1rem;">{{ $users_count }}</span> <input type="button" class="btn btn-primary btn-users-count" value="Modifier" />
                    </span>

                    <span class="users-count-update" style="display: none">
                        <input class="form-control" type="number" value="{{ $users_count }}" name="users_count" style="display: inline-block; width: 75px" />
                        <input type="button" class="btn btn-success btn-valid-users-count-update" value="Valider" />
                        <input type="button" class="btn btn-default btn-valid-users-count-cancel" value="Annuler" />
                    </span>
                </p>

                <hr>

                <h3>Compte</h3>

                <p>Solde du compte : <span style="font-size:3.5rem;">{{ number_format($balance, 2) }}€</span></p>
                <p class="daily-usage">Usage quotidien : <span class="value">{{ number_format($daily_cost, 2) }}</span>€</p>
                <p class="monthly-usage">Usage mensuel : <span class="value">{{ number_format($monthly_cost, 2) }}</span>€</p>

                <input type="text" class="form-control amount" name="amount" style="width:100px; display: inline-block;" placeholder="ex: 50.00" /> €
                <input type="button" class="btn btn-success btn-valid-fund-account" value="Réapprovisionner" />

                <form id="payment-form" method="post" action="{{ env('MERCANET_PAYMENT_URL') }}">
                    <input type="hidden" name="Data" value="">
                    <input type="hidden" name="InterfaceVersion" value="{{ env('MERCANET_VERSION') }}">
                    <input type="hidden" name="Seal" value="">
                </form>

                <hr>

                <p>
                    <input type="checkbox" name="email_alert" /> M'envoyer un email lorsque le solde du compte est inférieur à <input class="form-control" type="text" value="20" style="display: inline-block; width: 50px"/> €
                    <input type="button" class="btn btn-success" value="Valider" />
                </p>

                <hr>

                <h3>Historique de facturation</h3>

                @if ($invoices)
                    <table class="table table-bordered">
                        <tr>
                            <th>Identifiant</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Moyen de paiement</th>
                            <th width="160">Action</th>
                        </tr>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->identifier }}</td>
                            <td>{{ $invoice->creation_date }}</td>
                            <td>{{ number_format($invoice->amount, 2) }}€</td>
                            <td>{{ $invoice->payment_mean }}</td>
                            <td><a href="#" class="btn btn-info">Voir</a> <a href="#" class="btn btn-success">Télécharger</a></td>
                        </tr>
                        @endforeach
                    </table>
                @endif

                <hr>

                <h3>Se désinscrire</h3>
                <input type="button" class="btn btn-danger" value="Se désinscrire" />
            </div>
        </div>
    </div>
    {{ csrf_field() }}

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script>var route_payment_form = "{{ route('payment_form') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection