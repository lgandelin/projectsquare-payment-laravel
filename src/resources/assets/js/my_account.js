$(document).ready(function() {

    //Users count
    $('.btn-users-count').click(function() {

        $('.users-count-update').show();
        $('.users-count-display').hide();
    });

    $('.btn-valid-users-count-update').click(function() {

        $.ajax({
            type: "POST",
            url: route_update_users_count,
            data: {
                _token: $('input[name="_token"]').val(),
                users_count: $('input[name="users_count"]').val()
            },
            success: function (data) {
                if (data.success == false) {
                    alert(data.error);
                } else {
                    alert('Nombre d\'utilisateurs mis à jour');

                    $('.users-count-display').show();
                    $('.users-count-update').hide();
                }
            },
        });
    });

    $('.btn-valid-users-count-cancel').click(function() {

        $('.users-count-display').show();
        $('.users-count-update').hide();
    });
});