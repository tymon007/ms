# Generated by Django 2.2.6 on 2019-10-22 08:36

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('main_page', '0013_auto_20191022_1027'),
    ]

    operations = [
        migrations.AddField(
            model_name='user',
            name='salt',
            field=models.CharField(default='', help_text='Salt for password', max_length=200),
        ),
    ]
