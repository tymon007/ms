$(document).ready(function () {
    var chatID = $("#DATA-TO-SEND-MESS").data('chatId');

    $("#send").on('click', function () {
        var value = $("#input").val();
        $.ajax({
            url: 'sendmess.php',
            type: 'post',
            data: {
                chatID: chatID,
                text: value.replace(/\\/g, "\\\\").replace(/'/g, "\\'")
            },
            dataType: 'text',
        })
            .done(function (m) {
                document.getElementById('input').value = "";
            })
            .fail(function () {
                console.log("Wystąpił błąd w połączniu");
            })
    })

    var tzo = - new Date().getTimezoneOffset() / 60;
    setInterval(function () {
        $("#messages").load("fetch.php", { "time": tzo, "chatID": chatID });
    }, 100);
});