# Generated by Django 2.2.6 on 2019-10-22 08:26

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('main_page', '0011_gas_power_user_water'),
    ]

    operations = [
        migrations.AlterField(
            model_name='gas',
            name='value',
            field=models.CharField(help_text='Value of update', max_length=1000),
        ),
        migrations.AlterField(
            model_name='power',
            name='value',
            field=models.CharField(help_text='Value of update', max_length=1000),
        ),
        migrations.AlterField(
            model_name='water',
            name='value',
            field=models.CharField(help_text='Value of update', max_length=1000),
        ),
    ]
