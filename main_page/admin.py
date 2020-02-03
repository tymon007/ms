from django.contrib import admin
from .models import User, Curiosity, Gas, Power, Water

# Register your models here.


@admin.register(User)
class UserAdmin(admin.ModelAdmin):
    list_display = ('id', 'username', 'email', 'password', 'salt', 'howManyPeople')
    fields = ['id', 'username', 'email', 'password', 'salt', 'howManyPeople']


@admin.register(Curiosity)
class CuriosityAdmin(admin.ModelAdmin):
    list_display = ('id', 'text')
    fields = ['id', 'text']


@admin.register(Gas)
class GasAdmin(admin.ModelAdmin):
    list_display = ('idOfUser', 'date', 'value')
    fields = ['idOfUser', 'date', 'value']


@admin.register(Power)
class PowerAdmin(admin.ModelAdmin):
    list_display = ('idOfUser', 'date', 'value')
    fields = ['idOfUser', 'date', 'value']


@admin.register(Water)
class WaterAdmin(admin.ModelAdmin):
    list_display = ('idOfUser', 'date', 'value')
    fields = ['idOfUser', 'date', 'value']
