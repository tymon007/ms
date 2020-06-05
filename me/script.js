$(document).ready(function () {
    $('.activeMyModal[data-my-target="status"][data-is-status="true"]').on("click", function () {
        var text = this.innerHTML.replace("<br>", "");
        text = text.replace("<br />", "");
        text = text.replace("<br/>", "");
        $("#newStatus")[0].value = text.substr(0, 200);;
        $("#newStatus")[0].focus();
    })

    $("#statusSubmit").on("click", function () {
        var value = $("#newStatus")[0].value;
        var deleteStatusKey = $("#deleteStatus").is(':checked')

        $.ajax({
            url: 'changeStatus.php',
            type: 'post',
            data: {
                value: value.replace(/\\/g, "\\\\").replace(/'/g, "\\'"),
                deleteKey: deleteStatusKey
            },
            dataType: 'text',
        })
            .done(function (m) {
                location.reload();
                console.log(m);
            })
            .fail(function () {
                console.log("Wystąpił błąd w połączniu");
            })
    });

    $("#status .closeMyModal").on("click", function () {
        $("#newStatus")[0].value = "";
    })

    $(".information .verticalLine").each(function () {
        var leftHeight = this.parentNode.children[0].clientHeight;
        var rightHeight = this.parentNode.children[2].clientHeight;
        if (leftHeight > rightHeight) {
            this.style.height = leftHeight + "px";
        }
        else {
            this.style.height = rightHeight + "px";
        }
    })

    $("#sendPostSubmit").on("click", function () {
        var myId = $("#DATA-TO-SEND-POST")[0].dataset.myId;
        var title = $("#postTitle")[0].value;
        var text = $("#postText")[0].value;
        var pictures = null;
        var video = null;
        var audio = null;
        var docs = null;
        var forward = null;

        if (!text) {
            alert($("#DATA-TO-SEND-POST")[0].dataset.alertEmptyTextarea);
            return;
        }

        $.ajax({
            url: 'sendPost.php',
            type: 'post',
            data: {
                whoID: myId,
                bossPageID: myId,
                title: title.replace(/\\/g, "\\\\").replace(/'/g, "\\'"),
                text: text.replace(/\\/g, "\\\\").replace(/'/g, "\\'"),
                pictures: pictures,
                video: video,
                audio: audio,
                docs: docs,
                forward: forward
            },
            dataType: 'text',
        })
            .done(function (m) {
                location.reload();
                console.log(m);
            })
            .fail(function () {
                console.log("Wystąpił błąd w połączniu");
            })
    })

    $("#writePost .closeMyModal").on("click", function () {
        $("#postTitle")[0].value = "";
        $("#postText")[0].value = "";
        $("#postText").css("height", "auto");
    })

    $(".posts .post .who-posted .image-name .name--time-date .time-date").each(function (event) {
        $.ajax({
            url: 'changeTimeToLocal.php',
            type: 'post',
            data: {
                timestamp: this.children[0].dataset.timestamp,
                tzo: - new Date().getTimezoneOffset() / 60
            },
            dataType: 'text',
        })
            .done(function (dateTime) {
                date = dateTime.split('|')[0];
                time = dateTime.split('|')[1];
                $(".posts .post .who-posted .image-name .name--time-date .time-date")[event].children[1].innerHTML = date;
                $(".posts .post .who-posted .image-name .name--time-date .time-date")[event].children[3].innerHTML = time;
            })
            .fail(function () {
                console.log("Wystąpił błąd w połączniu");
            })
    })

    $(".posts .post .text .gottenText").each(function () {
        if (this.innerHTML.length > 370) {
            var newString = this.innerHTML.substr(0, 370);
            var arrayWords = newString.split(' ');
            var resultArray1 = [];
            for (var i = 0, j = 0; i < arrayWords.length; i++) {
                if (arrayWords[i] == '' || arrayWords[i] == '\n' || arrayWords[i] == '\t' || arrayWords[i] == '\r') {
                    continue;
                }
                resultArray1[j] = arrayWords[i];
                j++;
            }
            if (resultArray1.length > 1) var resultArray2 = resultArray1.slice(0, resultArray1.length - 1)
            else var resultArray2 = resultArray1
            var resultString = resultArray2.join(' ');
            this.parentNode.children[1].innerHTML = resultString + ' <span class="see-more">see more......</span>';
        } else {
            this.parentNode.children[1].innerHTML = this.innerHTML;
        }
    })

    $(".see-more").on("click", function () {
        this.parentNode.innerHTML = this.parentNode.parentNode.children[0].innerHTML;
    })

    $(".likes").on("click", function () {
        if (this.classList.contains("_yes")) {
            this.classList.remove("_yes");
            this.classList.add("_no");
            $.ajax({
                url: 'unlikeThisPost.php',
                type: 'post',
                data: {
                    idWhoUnliked: $("#DATA-TO-SEND-POST")[0].dataset.myId,
                    idPost: this.parentNode.parentNode.dataset.postId
                },
                dataType: 'text',
            })
                .done(function (m) {
                    console.log(m);
                })
                .fail(function () {
                    console.log("Wystąpił błąd w połączniu");
                })
        } else if (this.classList.contains("_no")) {
            this.classList.remove("_no");
            this.classList.add("_yes");
            console.log($("#DATA-TO-SEND-POST").data('myId'))
            $.ajax({
                url: 'likeThisPost.php',
                type: 'post',
                data: {
                    idWhoLiked: $("#DATA-TO-SEND-POST").data('myId'),
                    idPost: this.parentNode.parentNode.dataset.postId
                },
                dataType: 'text',
            })
                .done(function (m) {
                    console.log(m);
                })
                .fail(function () {
                    console.log("Wystąpił błąd w połączniu");
                })
        }
    })

    $(".comments, .forwards").on("click", function () {
        if (this.classList.contains("_yes")) {
            this.classList.remove("_yes");
            this.classList.add("_no");
        } else if (this.classList.contains("_no")) {
            this.classList.remove("_no");
            this.classList.add("_yes");
        }
    })
});