# eitf05
EITF05 Webbsäkerhet - `Web Shop Under Attack`

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
