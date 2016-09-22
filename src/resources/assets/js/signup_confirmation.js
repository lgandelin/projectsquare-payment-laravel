var timeOutId = 0;
var checkPlatformAvailability = function () {
    $.ajax({
        url: route_check_platform_url,
        data: {
            _token: $('input[name="_token"]').val(),
        },
        success: function (data) {
            if (data.success == false) {
                timeOutId = setTimeout(checkPlatformAvailability, 2000);
            } else {
                clearTimeout(timeOutId);
                alert(data.url);
            }
        }
    });
};

$(document).ready(function() {
    checkPlatformAvailability();
});