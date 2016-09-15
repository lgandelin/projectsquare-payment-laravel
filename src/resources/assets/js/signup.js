var users_count = 1;

$(document).ready(function() {

    //Users count slider
    var slider = $("#slider_users_count").slider({
        tooltip: 'always'
    });

    $("#slider_users_count").on("change", function(slideEvt) {
        users_count = slideEvt.value.newValue;
        $('input[name="users_count"]').val(users_count);
        var amount = 27 + 17 * users_count;
        $('.total').text(amount.toFixed(2));
    });


    //Steps navigation
    $('#step-2, #step-3').hide();

    $(".stepwizard-step span:not([disabled])").click(function() {
        displayTab($(this).attr('data-tab'));
    });

    $('.back-step-1').click(function() {
        displayTab(1);
    });

    $('.back-step-2').click(function() {
        displayTab(2);
    });


    //Steps validation
    $('.valid-step-1').click(function() {
        $('#step-1 .required').removeClass('invalid');
        var error = false;
        $('#step-1 .required').each(function() {
            if ($(this).val() == "") {
                $(this).addClass('invalid');
                error = true;
            }
        });

        if (!error)
            displayTab(2);
    });

    $('.valid-step-2').click(function() {
        $('#step-2 .required').removeClass('invalid');
        var error = false;
        $('#step-2 .required').each(function() {
            if ($(this).val() == "") {
                $(this).addClass('invalid');
                error = true;
            }
        });

        if (!error)
            displayTab(3);
    });


    //Alerts close buttons
    $('.alert .close').click(function() {
        $(this).closest('.alert').fadeOut();
    });

    $('.alert').delay(7500).fadeOut();
});

function displayTab(tab) {
    $('.setup-content').hide();
    $('#step-' + tab).show();

    $('.stepwizard-step span').addClass('btn-default').removeClass('btn-primary');
    $('.stepwizard-step span[data-tab="' + tab + '"]').removeAttr('disabled').addClass('btn-primary').removeClass('btn-default');

    if (tab == 3) {
        loadEnteredValues();
    }
}

function loadEnteredValues() {
    $('.name_value').text($('input[name="name"]').val());
    $('.slug_value').text($('input[name="slug"]').val() + ".projectsquare.io");
    $('.users_count_value').text(users_count);
    $('.administrator_email_value').text($('input[name="administrator_email"]').val());
    $('.administrator_last_name_value').text($('input[name="administrator_last_name"]').val());
    $('.administrator_first_name_value').text($('input[name="administrator_first_name"]').val());
    $('.administrator_billing_address_value').text($('textarea[name="administrator_billing_address"]').val());
    $('.administrator_zipcode_value').text($('input[name="administrator_zipcode"]').val());
    $('.administrator_city_value').text($('input[name="administrator_city"]').val());
}