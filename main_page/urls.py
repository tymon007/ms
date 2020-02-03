from django.urls import path, re_path
from . import views

urlpatterns = [
    re_path(r'^$', views.main_page, name='main_page'),
    re_path(r'^log_in/$', views.log_in, name="log_in"),
    re_path(r'^auth_login/$', views.auth_login, name="auth_login"),
    re_path(r'^sign_in/$', views.sign_in, name='sign_in'),
    re_path(r'^auth_signin/$', views.auth_signin, name="auth_signin"),
    re_path(r'^logout/$', views.logout, name="log_out"),
    re_path(r'^me/$', views.me, name="me"),
    re_path(r'^timer/$', views.timer, name="timer"),
    re_path(r'^timer/addValue/$', views.timer_addValue, name="timer_addValue"),
    re_path(r'^food/$', views.food, name="food"),
    re_path(r'^gas/$', views.gas, name="gas"),
    re_path(r'^gas/addValue/$', views.gas_addValue, name="gas_addValue"),
    re_path(r'^power/$', views.power, name="power"),
    re_path(r'^power/addValue/$', views.power_addValue, name="power_addValue"),
    re_path(r'^power/cropAddValue/$', views.power_cropAddValue, name="power_cropAddValue"),
    re_path(r'^water/$', views.water, name="water"),
    re_path(r'^water/addValue/$', views.water_addValue, name="water_addValue"),
    re_path(r'^credits/$', views.credits, name="credits"),
    re_path(r'^.*$', views.httpNotFound, name="not_found"),
]
