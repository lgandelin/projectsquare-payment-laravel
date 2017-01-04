var users_count = 1;

$(document).ready(function() {

    //Users count slider
    var slider = $("#slider_users_count").slider({
        tooltip: 'always'
    });

    $("#slider_users_count").on("change", function(slideEvt) {
        users_count = slideEvt.value.newValue;
        $('input[name="users_count"]').val(users_count);
        $('.users_count').text(users_count);
        var amount = parseFloat($('#platform_monthly_cost').val()) + parseFloat($('#user_monthly_cost').val()) * users_count;
        $('.total').text(amount);
    });


    //Steps navigation
    $('#step-2, #step-3').hide();

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

        if ($('input[name="slug"]').val() == "") {
            $('input[name="slug"]').addClass('invalid');
            error = true;
        } else if ($('input[name="slug"]').attr('data-verified') == "0") {
            if (!checkSlug()) {
                error = true;
            }
        }

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


    //Check platform slug
    $('.check-slug-btn').click(function() {
        checkSlug();
    });

    $('input[name="slug"]').change(function() {
        $('input[name="slug"]').attr('data-verified', 0);

        $('.check-slug-btn').removeClass('verification-success').removeClass('verification-in-progress');
        $('.check-slug-btn').val('Vérifier');
    });

    $('input[name="name"]').focusout(function() {
        if ($('input[name="name"]').val() != "" && $('input[name="slug"]').val() == "") {
            var slug = slugify($('input[name="name"]').val());
            $('input[name="slug"]').val(slug);
            checkSlug();
        }
    });

    $('input[name="slug"]').focusout(function() {
        if ($('input[name="slug"]').val() != "") {
            checkSlug();
        }
    });
});

function displayTab(tab) {
    $('.setup-content').hide();
    $('#step-' + tab).show();

    $('.stepwizard-step').removeClass('active-step');
    $('.stepwizard-step span[data-tab="' + tab + '"]').closest('.stepwizard-step').addClass('active-step');

    if (tab == 3) {
        loadEnteredValues();
    }
}

function loadEnteredValues() {
    $('.name_value').text($('input[name="name"]').val());
    $('.slug_value').text($('input[name="slug"]').val() + ".projectsquare.io");
    $('.users_count_value').text($('input[name="users_count"]').val());
    $('.administrator_email_value').text($('input[name="administrator_email"]').val());
    $('.administrator_last_name_value').text($('input[name="administrator_last_name"]').val());
    $('.administrator_first_name_value').text($('input[name="administrator_first_name"]').val());
    $('.administrator_billing_address_value').text($('textarea[name="administrator_billing_address"]').val());
    $('.administrator_zipcode_value').text($('input[name="administrator_zipcode"]').val());
    $('.administrator_city_value').text($('input[name="administrator_city"]').val());
}

function checkSlug() {
    if ($('input[name="slug"]').attr('data-verified') == "1") {
        return true;
    }

    $('input[name="slug"]').removeClass('invalid');

    $('.check-slug-btn').toggleClass('verification-success').toggleClass('verification-in-progress');
    $('.check-slug-btn').val('Vérification ...');

    $.ajax({
        type: "POST",
        url: route_check_slug,
        data: {
            _token: $('input[name="_token"]').val(),
            slug: $('input[name="slug"]').val()
        },
        success: function (data) {
            if (data.success == false) {
                $('input[name="slug"]').addClass('invalid');
                $('.check-slug-btn').addClass('verification-error').removeClass('verification-in-progress');
                $('.check-slug-btn').val('URL indisponible');
                setTimeout(function() {
                    $('.check-slug-btn').removeClass('verification-error');
                    $('.check-slug-btn').removeClass('verification-success');
                    $('.check-slug-btn').val('Vérifier');
                }, 2000);
            } else {
                $('input[name="slug"]').attr('data-verified', 1);
                $('.check-slug-btn').removeClass('verification-in-progress').addClass('verification-success');
                $('.check-slug-btn').val('URL disponible');
            }
        }
    });
}

function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

