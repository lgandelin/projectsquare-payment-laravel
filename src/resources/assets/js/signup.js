$(document).ready(function() {

    //Form validation
    $('.signup .try input[type="submit"]').click(function() {
        $('.try .loading').show();
        $('.signup .error').hide();
        var submit_button = $(this);
        submit_button.hide();
        $.ajax({
            type: "POST",
            url: route_free_trial_handler,
            data: {
                _token: $('input[name="_token"]').val(),
                email: $('.signup .try input[name="email"]').val(),
                password: $('.signup .try input[name="password"]').val(),
                url: $('.signup .try input[name="url"]').val()
            },
            success: function (data) {
                if (data.success == false) {
                    $('.signup .try .loading').hide();
                    submit_button.show();
                    $('.signup .error').show().text(data.error);
                } else {
                    window.location.href = data.redirection_url;
                }
            }
        });
    });

    //Anchor
    $('a[href^="#"]').click(function(){
        var id = $(this).attr("href");
        var offset = $(id).offset().top;
        $('html, body').animate({scrollTop: offset}, 800);

        return false;
    });

    //Features
    $('.bloc_fonctionnalite1').click(function() {
        $('.feature-content').hide();
        $('#bloc_fonctionnalite1-content').show();
        displayFeature(1);
    });

    $('.bloc_fonctionnalite2').click(function() {
        $('.feature-content').hide();
        $('#bloc_fonctionnalite2-content').show();
        displayFeature(4);
    });

    $('.bloc_fonctionnalite3').click(function() {
        $('.feature-content').hide();
        $('#bloc_fonctionnalite3-content').show();
        displayFeature(7);
    });

    $('.bloc_fonctionnalite4').click(function() {
        $('.feature-content').hide();
        $('#bloc_fonctionnalite4-content').show();
        $('.feature-image').hide();
    });

    $('.features li').click(function(e) {
        e.preventDefault();
        displayFeature($(this).data('feature'));
    });

    function displayFeature(tab) {
        $('.features li').removeClass('active');
        $('.feature-image').hide();
        $('#feature-' + tab).show();
        $('.features li[data-feature="' + tab + '"]').addClass('active');
    }

    //Alerts close buttons
    $('.alert .close').click(function() {
        $(this).closest('.alert').fadeOut();
    });

    $('.alert').delay(7500).fadeOut();
});

