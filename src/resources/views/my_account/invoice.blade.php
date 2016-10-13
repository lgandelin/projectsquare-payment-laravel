<h1>Facture #{{ $invoice->getIdentifier() }}</h1>

<p>Montant : {{ number_format($invoice->getAmount(), 2) }}€</p>
<p>Date : {{ $invoice->creation_date }}</p>
<p>Moyen de paiement : {{ $invoice->getPaymentMean() }}</p>