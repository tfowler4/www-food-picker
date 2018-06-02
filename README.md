# www-food-picker
Picking food and stuff

How to setup for local

***C:\xampp\apache\conf\extra***
***Add these lines***
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/www-food-picker"
    ServerName local.foods.com
    ServerAlias localhost/www-food-picker

    <Directory "C:/xampp/htdocs/www-food-picker">
        Options All

        AllowOverride All

        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>

***C:\WINDOWS\System32\drivers\etc***
***Add this lines***
127.0.0.1       local.foods.com