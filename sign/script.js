$(document).ready(function () {

    $("#log-pseudo-submit").on("click", function (evt) {

        evt.preventDefault();

        var error = 0;       

        // free Email
        var username = document.querySelector('input[name="login"]').value;
        if (username != "") {
            $.post("freeLogin.php", { text: username }, function (m) {
                console.log(m)
                if (m != 0) {
                    $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
                    $("#busyEmail").attr("class", "invalid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This username is busy!";
                    document.getElementById("incorrectEmail").innerHTML = "";
                    error += 1;
                } else {
                    $('input[name="login"]').removeClass("is-invalid").addClass("is-valid");
                    $("#busyEmail").attr("class", "valid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This email is free!";
                    if (email != "") {
                        var reg = /^([A-Za-z0-9_\-\.])+$/;
                        if (reg.test(email) == false) {
                            $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
                            $("#incorrectEmail").attr("class", "invalid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This username is incorrect!";
                            error += 1;
                        } else {
                            $('input[name="login"]').removeClass("is-invalid").addClass("is-valid");
                            $("#incorrectEmail").attr("class", "valid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This username is correct!";
                        }
                    }
                }
            });
        } else {
            $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
            $("#incorrectEmail").attr("class", "invalid-feedback")
            document.getElementById("incorrectEmail").innerHTML = "Type in your login!";
            error += 1;
        }

        // valid password
        var password1 = document.querySelector('input[name="password1"]').value;
        var password2 = document.querySelector('input[name="password2"]').value;
        if (password1 != "" && password2 != "") {
            if (password1 == password2) {
                if (password1.length >= 3) {
                    $('input[name="password1"]').removeClass("is-invalid").addClass("is-valid");
                    $('input[name="password2"]').removeClass("is-invalid").addClass("is-valid");
                    $("#wrongPassword").attr("class", "valid-feedback")
                    document.getElementById("wrongPassword").innerHTML = "Passwords are the same!";
                } else {
                    $('input[name="password1"]').removeClass("is-valid").addClass("is-invalid");
                    $('input[name="password2"]').removeClass("is-valid").addClass("is-invalid");
                    $("#wrongPassword").attr("class", "invalid-feedback")
                    document.getElementById("wrongPassword").innerHTML = "Length of password must be more than 5 symbols!";
                    error += 1;
                }
            } else {
                $('input[name="password1"]').removeClass("is-valid").addClass("is-invalid");
                $('input[name="password2"]').removeClass("is-valid").addClass("is-invalid");
                $("#wrongPassword").attr("class", "invalid-feedback")
                document.getElementById("wrongPassword").innerHTML = "Passwords do not match!";
                error += 1;
            }
        } else {
            $('input[name="password1"]').removeClass("is-valid").addClass("is-invalid");
            $('input[name="password2"]').removeClass("is-valid").addClass("is-invalid");
            $("#wrongPassword").attr("class", "invalid-feedback")
            document.getElementById("wrongPassword").innerHTML = "Type in your passwords!";
            error += 1;
        }

        setTimeout(function () {
            if (error == 0) {
                $("#origin-submit").click();
            }
        }, 100);
    });

    $('input[name="password1"]').on("input", function () {
        /^(?=.*[0-9])(?=.*[\041-\057\072-\077\100\133-\140\173-\176])[a-zA-Z0-9\041-\057\072-\077\100\133-\140\173-\176]{5,30}$/
        var password = this.value; // Получаем пароль из формы
        var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
        var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
        var digits = "0123456789"; // Цифры
        var specials = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~" // Спецсимволы
        var is_s = false; // Есть ли в пароле буквы в нижнем регистре
        var is_b = false; // Есть ли в пароле буквы в верхнем регистре
        var is_d = false; // Есть ли в пароле цифры
        var is_sp = false; // Есть ли в пароле спецсимволы
        for (var i = 0; i < password.length; i++) {
            /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
            if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
            else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
            else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
            else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
        }
        var rating = 0;
        var text = "";
        if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
        if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
        if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
        if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
        /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
        if (password.length < 6 && rating < 3) {
            $("#howComplexIsPassword").removeClass("bg-success bg-warning").addClass("bg-danger");
            $("#howComplexIsPassword").attr("style", "width: 33%");
            $("#howComplexIsPassword").attr("aria-valuemin", "33");
        }
        else if (password.length < 6 && rating >= 3) {
            $("#howComplexIsPassword").removeClass("bg-success bg-danger").addClass("bg-warning");
            $("#howComplexIsPassword").attr("style", "width: 67%");
            $("#howComplexIsPassword").attr("aria-valuemin", "67");
        }
        else if (password.length >= 8 && rating < 3) {
            $("#howComplexIsPassword").removeClass("bg-success bg-danger").addClass("bg-warning");
            $("#howComplexIsPassword").attr("style", "width: 67%");
            $("#howComplexIsPassword").attr("aria-valuemin", "67");
        }
        else if (password.length >= 8 && rating >= 3) {
            $("#howComplexIsPassword").removeClass("bg-warning bg-danger").addClass("bg-success");
            $("#howComplexIsPassword").attr("style", "width: 100%");
            $("#howComplexIsPassword").attr("aria-valuemin", "100");
        }
        else if (password.length >= 6 && rating == 1) {
            $("#howComplexIsPassword").removeClass("bg-success bg-warning").addClass("bg-danger");
            $("#howComplexIsPassword").attr("style", "width: 33%");
            $("#howComplexIsPassword").attr("aria-valuemin", "33");
        }
        else if (password.length >= 6 && rating > 1 && rating < 4) {
            $("#howComplexIsPassword").removeClass("bg-success bg-danger").addClass("bg-warning");
            $("#howComplexIsPassword").attr("style", "width: 67%");
            $("#howComplexIsPassword").attr("aria-valuemin", "67");
        }
        else if (password.length >= 6 && rating == 4) {
            $("#howComplexIsPassword").removeClass("bg-warning bg-danger").addClass("bg-success");
            $("#howComplexIsPassword").attr("style", "width: 100%");
            $("#howComplexIsPassword").attr("aria-valuemin", "100");
        }
    });
});