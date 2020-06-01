$(document).ready(function () {
    $('.search_conv').on("input", function () {
        var value = $(this).val();
        $.ajax({
            url: 'findConv.php',
            type: 'post',
            data: {
                value: value
            },
            dataType: 'text',
        })
            .done(function (m) {
                users = JSON.parse(m);
                $('.users').empty();
                for (var i = 0; i < users.length; i++) {
                    var isSelected = 'false';
                    var myclass = "user";
                    if (jQuery.inArray(parseInt(users[i].id), idsOfSelectedUsers) !== -1) {
                        isSelected = 'true';
                        myclass += " activated";
                    }
                    var div = $(`
                    <div class="` + myclass + `" data-user-id="` + users[i].id + `" data-is-selected="` + isSelected + `">
                        <div class="image" style="background-image: url('` + users[i].image + `')"></div>
                        <div class="name">` + users[i].firstName + " " + users[i].lastName + `</div>
                    </div>
                    `);
                    $('.users').append(div);
                }
            })
            .fail(function () {
                console.log("SOME ERROR DETECTED IN CONNECTION TO FILE");
            })
    })

    $(".message").each(function (i) {
        $.ajax({
            url: 'changeTimeToLocal.php',
            type: 'post',
            data: {
                timestamp: this.children[1].children[0].children[1].dataset.timestamp,
                tzo: - new Date().getTimezoneOffset() / 60
            },
            dataType: 'text',
        })
            .done(function (dateTime) {
                $(".message").eq(i).children().eq(1).children().eq(0).children().eq(1).text(dateTime);
            })
            .fail(function () {
                console.log("Wystąpił błąd w połączniu");
            })
    })
});