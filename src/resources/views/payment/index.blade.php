@extends('projectsquare-payment::master')

@section('page-title')
    S'abonner à Projectsquare
@endsection

@section('main-content')
    <div class="template payment_template">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">{{ trans('projectsquare-payment::pages.home_title') }}</a>
                    </li>
                    <li class="page_fille">
                        S'abonner à Projectsquare
                    </li>
                </ul>

                <h1 class="title background_blue">S'abonner à Projectsquare</h1>
            </div>
        </div>

        <div class="row">

            <div class="infos col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <ul>
                    <li>L'abonnement à Projectsquare est mensuel et sera renouvelé automatiquement à la fin des 30 premiers jours.</li>
                    <li>Avant la fin du premier mois, vous aurez la possibilité de demander le remboursement de votre abonnement si vous n'êtes pas satisfaits.</li>
                    <li>A chaque modification du nombre d'utilisateurs dans la plateforme,la facture suivante sera mise à jour en conséquence.</li>
                    <li>A tout moment, vous pourrez demander l'annulation de votre abonnement.</li>
                </ul>

                <div class="form-group payment-form">
                    <form action="{{ route('subscribe_handler') }}" method="POST">
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('STRIPE_KEY') }}"
                                data-amount="{{ $monthly_cost*100 }}"
                                data-name="Projectsquare"
                                data-email="{{ $user->email }}"
                                data-description="Abonnement mensuel à la plateforme"
                                data-image="{{ asset('img/payment/logo-projectsquare.png') }}"
                                data-locale="auto"
                                data-zip-code="false"
                                data-currency="eur"
                                data-label="Je m'abonne"
                                data-allow-remember-me="false">
                        </script>
                        {{ csrf_field() }}
                    </form>

                    <p><label>Nombre d'utilisateurs :</label> <span class="value">{{ $users_count }}</span></p>
                    <p><label>Abonnement mensuel :</label> <span class="value">{{ $monthly_cost }} &euro;</span></p>
                </div>

                <a href="{{ route('my_account') }}" class="button button-blue">Retour</a>

            </div>

        </div>
    </div>

    <script>var route_update_users_count = "{{ route('update_users_count') }}";</script>
    <script src="{{ asset('js/my_account.js') }}"></script>
@endsection