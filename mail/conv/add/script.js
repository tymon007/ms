$(document).ready(function () {
    $('.search_user').on("input", function () {
        var value = $(this).val();
        $.ajax({
            url: 'findUser.php',
            type: 'post',
            data: {
                value: value,
                chatId: $("#DATA-TO-CHOO-USER").data("chatId")
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
                    <div class="` + myclass + `" data-user-id="` + users[i].id + `" data-is-selected="` + isSelected + `" data-is-already-member="` + users[i].isAlreadyMember + `">
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
        if ($(this).data('isAlreadyMember') != true) {
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
        }

        console.log(idsOfSelectedUsers)
    })

    $('.nextStepToCreateConversation').on('click', function () {
        $.ajax({
            url: 'addMoreMembers.php',
            type: 'post',
            data: {
                ids: idsOfSelectedUsers,
                chatId: $("#DATA-TO-CHOO-USER").data("chatId")
            },
            dataType: 'text',
        })
            .done(function (m) {
                console.log(m);
                document.location.href = '/mail/conv?id=' + $("#DATA-TO-CHOO-USER").data("chatId");
            })
            .fail(function () {
                console.log("SOME ERROR DETECTED IN CONNECTION TO FILE");
            })
    })
});