$(document).ready(function () {
    $('.search_user').on("input", function () {
        var value = $(this).val();
        $.ajax({
            url: 'findUser.php',
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

    var idsOfSelectedUsers = [];

    $('.users').on('click', '.user', function () {
        if ($(this).data('isSelected') == false) {
            $(this).data('isSelected', true);
            idsOfSelectedUsers.push($(this).data('userId'));
        } else {
            $(this).data('isSelected', false);
            var newArray = [];
            for (var i = 0, j = 0; i < idsOfSelectedUsers.length; i++) {
                if (idsOfSelectedUsers[i] == $(this).data('userId')) {
                    continue;
                }
                newArray[j] = idsOfSelectedUsers[i];
                j++;
            }
            idsOfSelectedUsers = null;
            idsOfSelectedUsers = newArray;
        }

        this.classList.toggle('activated');

        if (idsOfSelectedUsers.length != 0) {
            $('.nextStepToCreateConversation').css('display', 'block');
        } else {
            $('.nextStepToCreateConversation').css('display', 'none');
        }
    })

    $('.nextStepToCreateConversation').on('click', function () {
        if (idsOfSelectedUsers.length == 1) {
            // two-user conversation
            $.ajax({
                url: 'createNewMess.php',
                type: 'post',
                data: {
                    ids: idsOfSelectedUsers,
                    btw2users: true
                },
                dataType: 'text',
            })
                .done(function (idOfNeededChat) {
                    console.log(idOfNeededChat);
                    document.location.href = '/mail/conv?id=' + idOfNeededChat;
                })
                .fail(function () {
                    console.log("SOME ERROR DETECTED IN CONNECTION TO FILE");
                })

        } else if (idsOfSelectedUsers.length > 1) {
            // many-user conversation

            $("#stepOne").animate({
                left: "-100%"
            }, "1s");

            $("#stepTwo").animate({
                left: "0"
            }, "1s");

            $('.nextStepToCreateConversation').css('display', 'none');

            // document.location.href = "#stepTwo"

            $('.imageofConversation').on('click', function () {
                $("#image4conv").click();
            })

            function handleFileSelect(evt) {
                var files = evt.target.files;

                for (var i = 0, f; f = files[i]; i++) {
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    reader.onload = (function () {
                        return function (e) {
                            $(".imageofConversation").css('background-image', 'url("' + e.target.result + '")');
                        };
                    })(f);

                    reader.readAsDataURL(f);
                }
            }

            $("#image4conv").on('change', handleFileSelect);

            $("#create-pseudo-submit").on("click", function () {
                var error = 0;
                if ($(".titleOfConversation").val() == "") {
                    $(".titleOfConversation").removeClass("is-valid").addClass("is-invalid");
                    $("#invalidConvName").attr("class", "invalid-feedback");
                    $("#invalidConvName").text("Enter name!");
                    error += 1;
                } else {
                    $(".titleOfConversation").removeClass("is-invalid").addClass("is-valid");
                    $("#invalidConvName").attr("class", "valid-feedback");
                    $("#invalidConvName").text("OK!");
                }
                if (error == 0) {
                    var formData = new FormData();
                    formData.append('ids', idsOfSelectedUsers);
                    formData.append('btw2users', false);
                    formData.append('nameOfConv', $('.titleOfConversation').val());
                    formData.append('imageOfConv', $('#image4conv')[0].files[0]);

                    $.ajax({
                        url: 'createNewMess.php',
                        type: 'post',
                        data: formData,
                        cache: false,
                        dataType: 'text',
                        processData: false,
                        contentType: false
                    })
                        .done(function (idOfNeededChat) {
                            console.log(idOfNeededChat);
                            document.location.href = '/mail/conv?id=' + idOfNeededChat;
                        })
                        .fail(function () {
                            console.log("SOME ERROR DETECTED IN CONNECTION TO FILE");
                        })
                }
            })

            $(".backToStepOne").on("click", function () {
                $("#stepTwo").animate({
                    left: "100%"
                }, "1s");

                $("#stepOne").animate({
                    left: ""
                }, "1s");

                $('.nextStepToCreateConversation').css('display', 'block');

                // document.location.href = "#stepOne"
            })
        } else {
            alert('Error');
            return;
        }
    })
});