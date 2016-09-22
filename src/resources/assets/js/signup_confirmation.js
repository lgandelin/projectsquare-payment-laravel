var timeOutId = 0;
var checkPlatformAvailability = function () {
    var timestamp = new Date().getTime();
    $.ajax({
        url: route_check_platform_url + '?t=' + timestamp,
        data: {
            _token: $('input[name="_token"]').val(),
        },
        success: function (data) {
            if (data.success == false) {
                timeOutId = setTimeout(checkPlatformAvailability, 2000);
            } else {
                clearTimeout(timeOutId);
                $('.progress').hide();
                $('.thanks p').text('Votre plateforme est prête ! Vous pouvez dès maintenant cliquer sur le bouton ci-dessous pour y accéder.');
                $('.platform-ready a').attr('href', data.url);
                $('.platform-ready').fadeIn();
            }
        }
    });
};

$(document).ready(function() {
    checkPlatformAvailability();
});