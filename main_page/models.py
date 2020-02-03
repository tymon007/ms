from django.db import models

# Create your models here.


class User(models.Model):
    id = models.IntegerField(primary_key=True)
    username = models.CharField(max_length=200, help_text="Type your username here")
    email = models.EmailField(help_text="Type your email here")
    password = models.CharField(max_length=200, help_text="Type your password here")
    salt = models.CharField(max_length=200, help_text="Salt for password", default="")
    howManyPeople = models.IntegerField(default=0)


class Curiosity(models.Model):
    id = models.IntegerField(primary_key=True)
    text = models.TextField(name="text", default="")


class Gas(models.Model):
    idOfUser = models.IntegerField(help_text="Id of user which")
    date = models.DateField(help_text="Date of adding update")
    value = models.CharField(max_length=1000, help_text="Value of update")


class Power(models.Model):
    idOfUser = models.IntegerField(help_text="Id of user which")
    date = models.DateField(help_text="Date of adding update")
    value = models.CharField(max_length=1000, help_text="Value of update")


class Water(models.Model):
    idOfUser = models.IntegerField(help_text="Id of user which")
    date = models.DateField(help_text="Date of adding update")
    value = models.CharField(max_length=1000, help_text="Value of update")

