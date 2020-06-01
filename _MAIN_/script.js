$(document).ready(function () {
    $(".mDropdown .mDropdownTit").on("click", function () {
        var __this = $(this);
        __this.parent().find(".mDropdownCon").css("display", "block");

        $(document).on("click", function (event) {
            if (__this.parent().find(event.target).length == 0) {
                __this.parent().find(".mDropdownCon").css("display", "none");
            }
        })
    })

    $("body").on("click", ".my_link", function () {
        var a = document.createElement("a");
        a.setAttribute("href", this.dataset.href);
        a.click();
    })

    $("body").on("click", "#pseudo-submit", function () {
        $("#origin-submit")[0].click();
    })

    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });

    $("#show_hide_repeat_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_repeat_password input').attr("type") == "text") {
            $('#show_hide_repeat_password input').attr('type', 'password');
            $('#show_hide_repeat_password i').addClass("fa-eye-slash");
            $('#show_hide_repeat_password i').removeClass("fa-eye");
        } else if ($('#show_hide_repeat_password input').attr("type") == "password") {
            $('#show_hide_repeat_password input').attr('type', 'text');
            $('#show_hide_repeat_password i').removeClass("fa-eye-slash");
            $('#show_hide_repeat_password i').addClass("fa-eye");
        }
    });

    $(".activeMyModal").on("click", function () {
        var id = $(this).data('myTarget');
        $("html, body").css("overflow", "hidden");
        $("#" + id)[0].classList.toggle("_nonActive")
        $("#" + id)[0].classList.toggle("_active")
    })

    $(".closeMyModal").on("click", function () {
        var id = $(this).parent().parent().parent().parent().parent().attr('id');
        $('[data-my-target="' + id + '"]').click();
        $("html, body").css("overflow", "auto");
    })
});