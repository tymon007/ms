from django.shortcuts import render, redirect
from .models import User, Curiosity, Gas, Power, Water
import matplotlib.pyplot as plt

from .forms import UploadFileForm
from PIL import Image

import random
import re
import datetime
import hashlib
import uuid


def main_page(request):
    # Ordinary instuctions
    curiosities = Curiosity.objects.all()
    random_curiosity = random.choice(curiosities)

    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return render(request, 'main_page/index.html',
                      context={'random_curiosity': random_curiosity, 'mark_is_logged': mark_is_logged})
    else:
        return redirect('log_out')


def log_in(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        return redirect('main_page')
    else:
        mark_is_logged = False
        exeptions = request.session.get('exeptions', False)
        request.session['exeptions'] = False
        return render(request, 'registration/login.html',
                      context={'mark_is_logged': mark_is_logged, 'exeptions': exeptions})


def auth_login(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        return redirect('main_page')
    else:
        def md5(s, raw_output=False):
            res = hashlib.md5(s.encode())
            if raw_output:
                return res.digest()
            return res.hexdigest()

        exeptions = []

        m_email = request.POST.get('email')
        m_password = request.POST.get('password')

        user = User.objects.filter(email=m_email)

        if len(user) > 0:
            if md5(md5(m_password) + user[0].salt) == user[0].password:
                request.session['is_logged'] = True
                request.session['id_user'] = user[0].id
                return redirect('main_page')

        exeptions.append('Some errors detected: Form is not valid')
        request.session['exeptions'] = exeptions
        return redirect('log_in')


def sign_in(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return redirect('main_page')
    else:
        mark_is_logged = False
        exeptions = request.session.get('exeptions', False)
        request.session['exeptions'] = False
        return render(request, 'registration/signup.html',
                      context={'mark_is_logged': mark_is_logged, 'exeptions': exeptions})


def auth_signin(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        return redirect('main_page')
    else:
        exeptions = []
        if request.method == 'POST':
            max_id = 0
            users = User.objects.all()
            for user in users:
                if max_id < user.id:
                    max_id = user.id
            max_id = max_id + 1

            username = request.POST.get('username')
            howManyPeople = request.POST.get('howManyPeople')
            email = request.POST.get('email')
            password1 = request.POST.get('password1')
            password2 = request.POST.get('password2')

            # username validation
            username_valid = True
            for char in username:
                if char.isalpha() or char.isdigit():
                    continue
                else:
                    username_valid = False
                    break

            # email validation
            regex = '^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$'
            if re.search(regex, email):
                email_valid = True
            else:
                email_valid = False

            # password validation
            if password1 == "" and password2 == "":
                passwords_valid = False
            else:
                if password1 != password2:
                    passwords_valid = False
                else:
                    if len(password1) < 5:
                        passwords_valid = False
                    else:
                        passwords_valid = True

            if username_valid:
                if email_valid:
                    if passwords_valid:
                        def md5(s, raw_output=False):
                            res = hashlib.md5(s.encode())
                            if raw_output:
                                return res.digest()
                            return res.hexdigest()

                        salt = (md5(str(uuid.uuid4)))[0:-8]
                        password = md5(md5(password1) + salt)

                        user_creation = User.objects.create(id=max_id, username=username, email=email,
                                                            password=password, salt=salt,
                                                            howManyPeople=howManyPeople)
                        request.session['is_logged'] = True
                        request.session['id_user'] = max_id
                        return redirect('main_page')
                    else:
                        exeptions.append(
                            'Some errors detected: Passwords do not match to requires')
                else:
                    exeptions.append(
                        'Some errors detected: Email is not valid')
            else:
                exeptions.append('Some errors detected: Username is not valid')
        else:
            exeptions.append('Some errors detected: Method is not POST')
        request.session['exeptions'] = exeptions
        return redirect('sign_in')


def logout(request):
    # checking if user logged in
    request.session['is_logged'] = False
    request.session['id_user'] = False
    return redirect('log_in')


def me(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        user = User.objects.filter(id=request.session.get('id_user'))[0]
        return render(request, 'aboutMe/me.html', context={'mark_is_logged': mark_is_logged, 'user': user})
    else:
        return redirect('log_out')


def timer(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return render(request, 'aboutMe/timer.html', context={'mark_is_logged': mark_is_logged})
    else:
        return redirect('log_out')


def timer_addValue(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        if request.method == 'GET':
            idOfUser = request.session.get('id_user')  # id of update

            today = datetime.datetime.now()
            date = today.strftime("%Y-%m-%d")  # date of update

            value = float(request.GET.get('time')) * 0.0000002  # value of update

            water_instance = Water.objects.create(idOfUser=idOfUser, date=date, value=value)
        return redirect('timer')
    else:
        return redirect('log_out')


def food(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return render(request, 'environment/food.html', context={'mark_is_logged': mark_is_logged})
    else:
        return redirect('log_out')


def gas(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        my_updates_gas = Gas.objects.filter(idOfUser=request.session.get('id_user')).order_by('date', 'value')
        howManyPeople = User.objects.filter(id=request.session.get('id_user'))[0].howManyPeople

        sum = 0
        for i in my_updates_gas:
            sum += float(i.value)

        if len(my_updates_gas) == 0:
            result = 'Nie masz wpisów'
            return render(request, 'environment/gas.html', context={'mark_is_logged': mark_is_logged, 'result': result})

        diff_date = (my_updates_gas[len(my_updates_gas) - 1].date - my_updates_gas[0].date)

        if diff_date.days != 0:
            srednio_na_osobe = float(sum / diff_date.days)

            srednio_na_osobe *= 365.25

            srednio_na_osobe /= howManyPeople

            if srednio_na_osobe > 300:
                result = 'Powyżej średniej krajowej. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
            else:
                result = 'Bardzo dobrze. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
        else:
            result = 'Nie masz wpisów'

        return render(request, 'environment/gas.html', context={'mark_is_logged': mark_is_logged, 'result': result})
    else:
        return redirect('log_out')


def gas_addValue(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        idOfUser = request.session.get('id_user')  # id of update

        today = datetime.datetime.now()
        date = today.strftime("%Y-%m-%d")  # date of update

        value = request.POST.get('value')  # value of update

        gas_instance = Gas.objects.create(idOfUser=idOfUser, date=date, value=value)
        return redirect('gas')
    else:
        return redirect('log_out')


def power(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        my_updates_power = Power.objects.filter(idOfUser=request.session.get('id_user')).order_by('date', 'value')
        howManyPeople = User.objects.filter(id=request.session.get('id_user'))[0].howManyPeople

        sum = 0
        for i in my_updates_power:
            sum += float(i.value)

        if len(my_updates_power) == 0:
            result = 'Nie masz wpisów'
            return render(request, 'environment/power.html', context={'mark_is_logged': mark_is_logged, 'result': result})

        diff_date = (my_updates_power[len(my_updates_power) - 1].date - my_updates_power[0].date)

        if diff_date.days != 0:
            srednio_na_osobe = float(sum / diff_date.days)

            srednio_na_osobe *= 365.25

            srednio_na_osobe /= howManyPeople

            if srednio_na_osobe > 300:
                result = 'Powyżej średniej krajowej. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
            else:
                result = 'Bardzo dobrze. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
        else:
            result = 'Nie masz wpisów'

        return render(request, 'environment/power.html', context={'mark_is_logged': mark_is_logged, 'result': result})
    else:
        return redirect('log_out')


def power_addValue(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        idOfUser = request.session.get('id_user')  # id of update

        today = datetime.datetime.now()
        date = today.strftime("%Y-%m-%d")  # date of update

        value = request.POST.get('value')  # value of update

        power_instance = Power.objects.create(idOfUser=idOfUser, date=date, value=value)
        return redirect('power')
    else:
        return redirect('log_out')


def power_cropAddValue(request):
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        if request.method == 'POST':
            mark_is_logged = True

            image = request.FILES.get('file_image', False)

            # def handle_uploaded_file(f):
            #     with open('some/file/name.txt', 'wb+') as destination:
            #         for chunk in f.chunks():
            #             destination.write(chunk)

            form = UploadFileForm(request.POST, request.FILES)
            # if form.is_valid():
                # handle_uploaded_file(request.FILES['file'])



            data = request.POST.get('data', False)
            fields = data.split('&')
            values = {
                'x': float(fields[0].split('=')[1]),
                'y': float(fields[1].split('=')[1]),
                'width': float(fields[2].split('=')[1]),
                'height': float(fields[3].split('=')[1]),
                'scaleX': float(fields[4].split('=')[1]),
                'scaleY': float(fields[5].split('=')[1]),
            }

            im = Image.open(image)
            width, height = im.size
            left = values.get('x')
            top = values.get('y')
            right = width - left - values.get('width')
            bottom = height - top - values.get('height')
            im1 = im.crop((left, top, right, bottom))
            # im1.show()

            return render(request, 'environment/power_crop_add_value.html', context={'mark_is_logged': mark_is_logged,
                                                                                     'image': image, 'data': values,
                                                                                     'width': width, 'height': height})
        else:
            mark_is_logged = True
            return render(request, 'environment/power_crop_add_value.html', context={'mark_is_logged': mark_is_logged,
                                                                                     'error': 'error'})
    else:
        return redirect('log_out')


def water(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        my_updates_water = Water.objects.filter(idOfUser=request.session.get('id_user')).order_by('date', 'value')
        howManyPeople = User.objects.filter(id=request.session.get('id_user'))[0].howManyPeople

        sum = 0
        for i in my_updates_water:
            sum += float(i.value)

        if len(my_updates_water) == 0:
            result = 'Nie masz wpisów'
            return render(request, 'environment/water.html',
                          context={'mark_is_logged': mark_is_logged, 'result': result})

        diff_date = (my_updates_water[len(my_updates_water) - 1].date - my_updates_water[0].date)

        if diff_date.days != 0:
            srednio_na_osobe = float(sum / diff_date.days)

            srednio_na_osobe *= 365.25

            srednio_na_osobe /= howManyPeople

            if srednio_na_osobe > 300:
                result = 'Powyżej średniej krajowej. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
            else:
                result = 'Bardzo dobrze. Twoja średnia na rok to - ' + str(
                    srednio_na_osobe) + ', srednia krajowa to - 220,5 m3 +- 79,5 m3'
        else:
            result = 'Nie masz wpisów'

        return render(request, 'environment/water.html', context={'mark_is_logged': mark_is_logged, 'result': result})
    else:
        return redirect('log_out')


def water_addValue(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        idOfUser = request.session.get('id_user')  # id of update

        today = datetime.datetime.now()
        date = today.strftime("%Y-%m-%d")  # date of update

        value = request.POST.get('value')  # value of update

        water_instance = Water.objects.create(
            idOfUser=idOfUser, date=date, value=value)
        return redirect('water')
    else:
        return redirect('log_out')


def credits(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return render(request, 'credits.html', context={'mark_is_logged': mark_is_logged})
    else:
        return redirect('log_out')


def httpNotFound(request):
    # checking if user logged in
    is_logged = request.session.get('is_logged', False)
    if is_logged:
        mark_is_logged = True
        return render(request, '404.html', context={'mark_is_logged': mark_is_logged})
    else:
        return redirect('log_out')
