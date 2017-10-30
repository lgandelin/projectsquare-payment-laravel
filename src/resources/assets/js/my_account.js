$(document).ready(function() {

    //Cancel subscription
    $('.cancel-subscription .button-red').click(function(e) {
        if (confirm('Etes-vous sûrs de vouloir annuler votre abonnement ?')) {
            return true;
        }

        return false;
    });

    //Reimburse subscription
    $('.refund-subscription .button-red').click(function(e) {
        if (confirm('Etes-vous sûrs de vouloir demander le remboursement de votre abonnement ?')) {
            return true;
        }

        return false;
    });
});