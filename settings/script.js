$(document).ready(function () {
    $("#photo").on("click", function () {
        $("#user-image")[0].click();
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
                    document.getElementById('photo').style.backgroundImage = 'url("' + e.target.result + '")';
                };
            })(f);

            reader.readAsDataURL(f);
        }
    }

    document.getElementById("user-image").addEventListener('change', handleFileSelect, false);

    $("#pseudo-submit").on("click", function (evt) {
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
                    $('input[name="firstName"]').removeClass("is-valid").addClass("is-invalid");
                    $('input[name="lastName"]').removeClass("is-valid").addClass("is-invalid");
                    $("#invalidName").attr("class", "invalid-feedback")
                    document.getElementById("invalidName").innerHTML = "Your name consists of not allowed symbols!";
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
                    $('input[name="firstName"]').removeClass("is-valid").addClass("is-invalid");
                    $('input[name="lastName"]').removeClass("is-valid").addClass("is-invalid");
                    $("#invalidName").attr("class", "invalid-feedback")
                    document.getElementById("invalidName").innerHTML = "Your name consists of not allowed symbols!";
                    error += 1;
                    break;
                }
            }
            if (error == 0) {
                $('input[name="firstName"]').removeClass("is-invalid").addClass("is-valid");
                $('input[name="lastName"]').removeClass("is-invalid").addClass("is-valid");
                $("#invalidName").attr("class", "valid-feedback")
                document.getElementById("invalidName").innerHTML = "Your names are correct!";
            }
        }

        // free Email
        var email = document.querySelector('input[name="email"]').value;
        if (email != "") {
            $.post("/freeEmail.php", { text: email }, function (m) {
                if (m != 0) {
                    $('input[name="emailr"]').removeClass("is-valid").addClass("is-invalid");
                    $("#busyEmail").attr("class", "invalid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This email is busy!";
                    document.getElementById("incorrectEmail").innerHTML = "";
                    error += 1;
                } else {
                    $('input[name="emailr"]').removeClass("is-invalid").addClass("is-valid");
                    $("#busyEmail").attr("class", "valid-feedback")
                    document.getElementById("busyEmail").innerHTML = "This email is free!";
                    if (email != "") {
                        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                        if (reg.test(email) == false) {
                            $('input[name="emailr"]').removeClass("is-valid").addClass("is-invalid");
                            $("#incorrectEmail").attr("class", "invalid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This email is incorrect!";
                            error += 1;
                        } else {
                            $('input[name="emailr"]').removeClass("is-invalid").addClass("is-valid");
                            $("#incorrectEmail").attr("class", "valid-feedback")
                            document.getElementById("incorrectEmail").innerHTML = "This email is correct!";
                        }
                    }
                }
            });
        }

        // valid password
        var passwordCUR = document.querySelector('input[name="passwordCUR"]').value;
        var passwordNEW = document.querySelector('input[name="passwordNEW"]').value;
        var passwordCON = document.querySelector('input[name="passwordCON"]').value;
        if (passwordNEW != "") {
            if (passwordCON != "") {
                if (passwordCUR != "") {
                    $.post("validpassword.php", { pass: passwordCUR }, function (m) {
                        valid = m;
                    });
                    setTimeout(function () {
                        if (valid == 'valid') {
                            if (passwordNEW == passwordCON) {
                                if (passwordNEW.length >= 6) {
                                    $('input[name="passwordNEW"]').removeClass("is-invalid").addClass("is-valid");
                                    $('input[name="passwordCON"]').removeClass("is-invalid").addClass("is-valid");
                                    $("#passwordsDoNotMatch").attr("class", "valid-feedback")
                                    document.getElementById("passwordsDoNotMatch").innerHTML = "Passwords are the same! Check your email to confirm changing password.";
                                } else {
                                    $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                                    $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                                    $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                                    document.getElementById("passwordsDoNotMatch").innerHTML = "Length of password must be more than 5 symbols!";
                                    error += 1;
                                }
                            } else {
                                $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                                $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                                $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                                document.getElementById("passwordsDoNotMatch").innerHTML = "Passwords do not match!";
                                error += 1;
                            }
                        } else {
                            $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                            $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                            $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                            document.getElementById("passwordsDoNotMatch").innerHTML = "You have entered bad current password!";
                            error += 1;
                        }
                    }, 499);
                } else {
                    $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                    $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                    $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                    document.getElementById("passwordsDoNotMatch").innerHTML = "Enter current password!";
                    error += 1;
                }
            } else {
                $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                document.getElementById("passwordsDoNotMatch").innerHTML = "Enter both fields for new password!";
                error += 1;
            }
        } else {
            if (passwordCON != "") {
                $('input[name="passwordNEW"]').removeClass("is-valid").addClass("is-invalid");
                $('input[name="passwordCON"]').removeClass("is-valid").addClass("is-invalid");
                $("#passwordsDoNotMatch").attr("class", "invalid-feedback")
                document.getElementById("passwordsDoNotMatch").innerHTML = "Enter both fields for new password!";
                error += 1;
            }
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
        }, 500);
    });

    $('input[name="passwordNEW"]').on("input", function () {
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

    var img_childrens_of_media = $(".media img");
    var width_of_children = img_childrens_of_media[0].getBoundingClientRect().width;
    var count_of_childrens = img_childrens_of_media.length;
    var width_of_parent_element = $(".media")[0].getBoundingClientRect().width;
    var margin_between_childrens = (width_of_parent_element - width_of_children * count_of_childrens) / (count_of_childrens - 1);
    var length = $(".media img").length;

    for (var i = 0; i < length; i++) {
        $(".media img")[i].style.margin = '0';
        if (i == 0) continue;
        $(".media img")[i].style.marginLeft = margin_between_childrens + 'px';
    }

    $(".lang_img").on("click", function () {
        var inputs = $(".input-lang");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute('checked')
            var images = $(".lang_img");
            for (var k = 0; k < images.length; k++) {
                images[i].classList.remove('selected_lang_img');
            }
            if (this.dataset.lang == inputs[i].getAttribute('value')) {
                inputs[i].setAttribute('checked', 'checked');
                this.classList.add('selected_lang_img')
            }
        }
    })

    $("#cancel").on("click", function () {
        this.parentNode.children[1].click();
    })
});