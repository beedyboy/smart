#Smart
#
This is the backend for restaurant management..
#
#
Find the database smartrestaurant.sql in the folder
#
#on line 24-30, set up your database credentials
#
#on line 59, in the config folder, change Ip address to your server ip



#
#
sudo nano /etc/apache2/sites-available/000-default.conf

<VirtualHost *:80>
    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    . . .
</VirtualHost>

sudo systemctl restart apache2# smart
# smartrest
