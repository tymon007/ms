# Generated by Django 2.2.6 on 2019-10-15 11:00

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('main_page', '0006_auto_20191015_1228'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='ciekawostki',
            name='ciekawostka',
        ),
        migrations.AddField(
            model_name='ciekawostki',
            name='tresc',
            field=models.TextField(default='haha'),
        ),
    ]
