$(document).ready(function () {
    var formData = new FormData();
    formData.append('chatId', $("#DATA-TO-CHAN-CONV").data('chatId'));

    $('.convImage').on('click', function () {
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
                    $(".convImage").css('background-image', 'url("' + e.target.result + '")');
                    formData.append('convImage', $('#image4conv')[0].files[0]);
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }

    $("#image4conv").on('change', handleFileSelect);

    $("#permissionsSave").on("click", function () {
        formData.append('sentMess', $('[name="sentMess"]').prop('checked'));
        formData.append('sentMedia', $('[name="sentMedia"]').prop('checked'));
        formData.append('sentGIFs', $('[name="sentGIFs"]').prop('checked'));
        formData.append('linkPreview', $('[name="linkPreview"]').prop('checked'));
        formData.append('makiPolls', $('[name="makiPolls"]').prop('checked'));
        formData.append('addMembers', $('[name="addMembers"]').prop('checked'));
        formData.append('pinMess', $('[name="pinMess"]').prop('checked'));
        formData.append('changeProf', $('[name="changeProf"]').prop('checked'));
    })

    $("#create-pseudo-submit").on("click", function () {
        var error = 0;
        if ($("#name").val() == "") {
            $("#name").removeClass("is-valid").addClass("is-invalid");
            $("#invalidConvName").attr("class", "invalid-feedback");
            $("#invalidConvName").text("Enter name!");
            error += 1;
        } else {
            $("#name").removeClass("is-invalid").addClass("is-valid");
            $("#invalidConvName").attr("class", "valid-feedback");
            $("#invalidConvName").text("OK!");
        }
        if (error == 0) {
            formData.append('convName', $('#name').val());
            formData.append('convDesc', $('#description').val());

            $.ajax({
                url: 'editGroup.php',
                type: 'post',
                data: formData,
                cache: false,
                dataType: 'text',
                processData: false,
                contentType: false
            })
                .done(function (m) {
                    console.log(m);
                    document.location.href = '/mail/conv/edit?id=' + $("#DATA-TO-CHAN-CONV").data('chatId');
                })
                .fail(function () {
                    console.log("SOME ERROR DETECTED IN CONNECTION TO FILE");
                })
        }
    })
});