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

                <p>Nombre d'utilisateurs : {{ $platform->users_count }} <input type="button" class="btn btn-primary" value="Modifier" /></p>

                <hr>

                <h3>Compte</h3>

                <p>Solde du compte : {{ number_format($platform->balance, 2) }}€ <input type="button" class="btn btn-success" value="Réapprovisionner" /></p>
                <p>Usage quotidien : {{ number_format($daily_cost, 2) }}€</p>
                <p>Usage mensuel : {{ number_format($monthly_cost, 2) }}€</p>
                <p>
                    <input type="checkbox" name="email_alert" /> M'envoyer un email lorsque le solde du compte est inférieur à <input class="form-control" type="text" value="20" style="display: inline-block; width: 50px"/> €
                    <input type="button" class="btn btn-success" value="Valider" />
                </p>

                <hr>

                <h3>Abonnement</h3>
                <input type="button" class="btn btn-danger" value="Se désinscrire" />
            </div>
        </div>
    </div>
@endsection