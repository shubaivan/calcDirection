$(document).ready(function() {
    $("#test").on('click', function () {
        $.ajax({
            type: 'POST',
            url: '/data',
            data: {
                'data': $('#input').val()
            },
            success: function (data, textStatus) {
                $("#result").append('<br>').append(data);
                console.log(data);
            },
            async: false,
            error: function (e) {
                console.log(e);
            }
        });
    })
});