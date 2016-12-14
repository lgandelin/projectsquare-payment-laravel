<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice->transaction->getIdentifier() }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">

        <div class="header row">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 logo">
                <ul class="reseaux-sociaux pull-right">
                    <li class="twitter">
                        <a href="https://twitter.com/projectsquareFR" target="_blank"></a>
                    </li>
                    <li class="linkedin">
                        <a href="https://www.linkedin.com/company/projectsquare?trk=company_logo" target="_blank"></a>
                    </li>
                </ul>

                <a href="http://projectsquare.io"><img src="{{ asset('img/header/logo-projectsquare-inline.png') }}" alt="Logo Projectsquare" width="293" height="53" /></a><br>
                <a href="http://projectsquare.io">http://projectsquare.io</a><br>
                <a href="mailto:contact@projectsquare.fr">contact@projectsquare.fr</a><br>
            </div>
        </div>

        <hr>

        <p>Facture #{{ $invoice->transaction->getIdentifier() }}</p>
        <p>Montant HT : {{ number_format($invoice->transaction->getAmount() / 1.2, 2) }}€</p>
        <p>TVA : {{ number_format(0.2 * $invoice->transaction->getAmount() / 1.2, 2) }}€</p>
        <p>Montant TTC : {{ number_format($invoice->transaction->getAmount(), 2) }}€</p>
        <p>Date : {{ $invoice->transaction->creation_date }}</p>
        <p>Moyen de paiement : {{ $invoice->transaction->getPaymentMean() }}</p>

        <hr>

        <p>Agence : {{ $invoice->platform->getName() }}</p>
        <p>{{ $invoice->administrator->getLastName() }} {{ $invoice->administrator->getFirstName() }}</p>
        <p>{{ $invoice->administrator->getBillingAddress() }}</p>
        <p>{{ $invoice->administrator->getZipcode() }} {{ $invoice->administrator->getCity() }}</p>

        <hr>

        <p>SARL Webaccess</p>
        <p>RCS + SIRET</p>
        <p>Numéro individuel d'identification à la TVA</p>

    </div>
</body>
</html>
