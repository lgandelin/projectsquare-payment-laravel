$(document).ready(function() {

    //Users count
    $('.btn-users-count').click(function() {

        $('.users-count-update').show();
        $('.users-count-display').hide();
    });

    $('.btn-valid-users-count-update').click(function() {
        var users_count = $('input[name="users_count"]').val();

        $.ajax({
            type: "POST",
            url: route_update_users_count,
            data: {
                _token: $('input[name="_token"]').val(),
                users_count: users_count
            },
            success: function (data) {
                if (data.success == false) {
                    alert(data.error);
                } else {
                    $('.users-count-display .value').text(users_count);

                    $('.users-count-display').show();
                    $('.users-count-update').hide();

                    $('.daily-usage .value').text(data.daily_cost.toFixed(2));
                    $('.monthly-usage .value').text(data.monthly_cost.toFixed(2));
                }
            },
        });
    });

    $('.btn-valid-users-count-cancel').click(function() {

        $('.users-count-display').show();
        $('.users-count-update').hide();
    });
});