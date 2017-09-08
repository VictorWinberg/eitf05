# eitf05
EITF05 Webbsäkerhet - `Web Shop Under Attack`

### Set up ssl connection
Copy and overide ssl-config/httpd.conf to /PATH/TO/MAMP/conf/apache
Copy and overide ssl-config/httpd-ssl.conf to /PATH/TO/MAMP/conf/apache/extra
COPY certificate ssl-confg/web-sec.course.com.crt to /PATH/TO/MAMP/conf/apache
COPY key ssl-config/web-sec.course.com.nopass.key to /PATH/TO/MAMP/conf/apahce
Restart the servers.

Go to https://localhost

### (OPTIONAL) Set up DNS for the lulz
Add the following line "127.0.0.1 web-sec.course.com" in /etc/hosts 
Go to https://web-sec.course.com

#### env.php
The `env.php` is gitignored, for security reasons. Make your own `env.php`-file with the environment values.

### Run php in terminal
`php -t public_html -c resources/php.ini -S localhost:8000`

### AMP - Display errors
1. Go to: `/Applications/<AMP>/bin/php/<php version>/conf/php.ini`
2. Set
```
error_reporting = E_ALL
display_errors = On
```

