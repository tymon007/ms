$(document).ready(function () {

    $("#log-pseudo-submit").on("click", function (evt) {

        evt.preventDefault();

        var error = 0;

        // first name and last name
        var firstName = $('input[name="firstName"]')[0].value;
        var lastName = $('input[name="lastName"]')[0].value;
        if (firstName != "" || lastName != "") {

            var firstNameLetters = firstName.split("");
            for (var i = 0; i < firstNameLetters.length; i++) {
                var s = firstNameLetters[i];
                if (s == 0 || s == 1 || s == 2 || s == 3 || s == 4 || s == 5 || s == 6 || s == 7 || s == 8 || s == 9 ||
                    s == "!" || s == "@" || s == "#" || s == "$" || s == "%" || s == "^" || s == "&" || s == "*" || s == "(" || s == ")" ||
                    s == "[" || s == "]" || s == "{" || s == "}" || s == ";" || s == ":" || s == "'" || s == "\"" || s == "<" || s == ">" ||
                    s == "," || s == "." || s == "/" || s == "?" || s == "\\" || s == "|" || s == "-" || s == "_" || s == "=" || s == "+") {
                    error += 1;
                    break;
                }
            }

            var lastNameLetters = lastName.split("");
            for (var i = 0; i < lastNameLetters.length; i++) {
                var s = lastNameLetters[i];
                if (s == 0 || s == 1 || s == 2 || s == 3 || s == 4 || s == 5 || s == 6 || s == 7 || s == 8 || s == 9 ||
                    s == "!" || s == "@" || s == "#" || s == "$" || s == "%" || s == "^" || s == "&" || s == "*" || s == "(" || s == ")" ||
                    s == "[" || s == "]" || s == "{" || s == "}" || s == ";" || s == ":" || s == "'" || s == "\"" || s == "<" || s == ">" ||
                    s == "," || s == "." || s == "/" || s == "?" || s == "\\" || s == "|" || s == "-" || s == "_" || s == "=" || s == "+") {
                    error += 1;
                    break;
                }
            }

            if (error == 0) {
                $('input[name="firstName"]').removeClass("is-invalid").addClass("is-valid");
                $('input[name="lastName"]').removeClass("is-invalid").addClass("is-valid");
                $("#invalidName").attr("class", "valid-feedback")
                document.getElementById("invalidName").innerHTML = "Your names are correct!";
            } else {
                $('input[name="firstName"]').removeClass("is-valid").addClass("is-invalid");
                $('input[name="lastName"]').removeClass("is-valid").addClass("is-invalid");
                $("#invalidName").attr("class", "invalid-feedback")
                document.getElementById("invalidName").innerHTML = "Your name consists of not allowed symbols!";
            }
        } else {
            $('input[name="firstName"]').removeClass("is-valid").addClass("is-invalid");
            $('input[name="lastName"]').removeClass("is-valid").addClass("is-invalid");
            $("#invalidName").attr("class", "invalid-feedback")
            document.getElementById("invalidName").innerHTML = "Type in your names!";
        }

        // free Email
        var email = document.querySelector('input[name="login"]').value;
        if (email != "") {
            $.post("freeEmail.php", { text: email }, function (m) {
                console.log(m)
                if (m != 0) {
                    $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
                    $("#busyEmail").attr("class", "invalid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This email is busy!";
                    document.getElementById("incorrectEmail").innerHTML = "";
                    error += 1;
                } else {
                    $('input[name="login"]').removeClass("is-invalid").addClass("is-valid");
                    $("#busyEmail").attr("class", "valid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This email is free!";
                    if (email != "") {
                        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                        if (reg.test(email) == false) {
                            $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
                            $("#incorrectEmail").attr("class", "invalid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This email is incorrect!";
                            error += 1;
                        } else {
                            $('input[name="login"]').removeClass("is-invalid").addClass("is-valid");
                            $("#incorrectEmail").attr("class", "valid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This email is correct!";
                        }
                    }
                }
            });
        } else {
            $('input[name="login"]').removeClass("is-valid").addClass("is-invalid");
            $("#incorrectEmail").attr("class", "invalid-feedback")
            document.getElementById("incorrectEmail").innerHTML = "Type in your email!";
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

        //valid Date
        var day = $("#day option:selected").attr("value");
        var month = $("#month option:selected").attr("value");
        var year = $("#year option:selected").attr("value");
        if (day != undefined && month != undefined && year != undefined) {
            if (month == 2) {
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) {
                    $("#day").removeClass("is-invalid").addClass("is-valid");
                    $("#month").removeClass("is-invalid").addClass("is-valid");
                    $("#year").removeClass("is-invalid").addClass("is-valid");
                    $("#wrongDate").attr("class", "valid-feedback")
                    document.getElementById("wrongDate").innerHTML = "Date is correct!";
                } else {
                    $("#day").removeClass("is-invalid").addClass("is-valid");
                    $("#month").removeClass("is-invalid").addClass("is-valid");
                    $("#year").removeClass("is-valid").addClass("is-invalid");
                    $("#wrongDate").attr("class", "invalid-feedback")
                    document.getElementById("wrongDate").innerHTML = "Invalid date!";
                    error += 1;
                }
            } else {
                $("#day").removeClass("is-invalid").addClass("is-valid");
                $("#month").removeClass("is-invalid").addClass("is-valid");
                $("#year").removeClass("is-invalid").addClass("is-valid");
                $("#wrongDate").attr("class", "valid-feedback")
                document.getElementById("wrongDate").innerHTML = "Date is correct!";
            }
        } else if (day == 30) {
            if (month == 2) {
                $("#day").removeClass("is-invalid").addClass("is-valid");
                $("#month").removeClass("is-valid").addClass("is-invalid");
                $("#year").removeClass("is-invalid").addClass("is-valid");
                $("#wrongDate").attr("class", "invalid-feedback")
                document.getElementById("wrongDate").innerHTML = "Invalid date!";
                error += 1;
            } else {
                $("#day").removeClass("is-invalid").addClass("is-valid");
                $("#month").removeClass("is-invalid").addClass("is-valid");
                $("#year").removeClass("is-invalid").addClass("is-valid");
                $("#wrongDate").attr("class", "valid-feedback")
                document.getElementById("wrongDate").innerHTML = "Date is correct!";
            }
        } else if (day == 31) {
            if (month == 2 || month == 4 || month == 6 || month == 9 || month == 11) {
                $("#day").removeClass("is-invalid").addClass("is-valid");
                $("#month").removeClass("is-valid").addClass("is-invalid");
                $("#year").removeClass("is-invalid").addClass("is-valid");
                $("#wrongDate").attr("class", "invalid-feedback")
                document.getElementById("wrongDate").innerHTML = "Invalid date!";
                error += 1;
            } else {
                $("#day").removeClass("is-invalid").addClass("is-valid");
                $("#month").removeClass("is-invalid").addClass("is-valid");
                $("#year").removeClass("is-invalid").addClass("is-valid");
                $("#wrongDate").attr("class", "valid-feedback")
                document.getElementById("wrongDate").innerHTML = "Date is correct!";
            }
        } else {
            $("#day").removeClass("is-invalid").addClass("is-valid");
            $("#month").removeClass("is-invalid").addClass("is-valid");
            $("#year").removeClass("is-invalid").addClass("is-valid");
            $("#wrongDate").attr("class", "valid-feedback")
            document.getElementById("wrongDate").innerHTML = "Date is correct!";
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