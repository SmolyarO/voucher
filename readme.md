# Voucher

## Setup project:

### 1. Configure your VirtualHost. For example:
```apacheconfig
<VirtualHost *:80>
  ServerName voucher.dev
  ServerAlias voucher.dev
  <Directory /var/www/voucher>
    Order allow,deny
    Allow from all
  </Directory>
 
  CustomLog "/var/www/logs/dev-access_log" combinedmassvhost
  ErrorLog "/var/www/logs/dev-error_log"
 
  VirtualDocumentRoot /var/www/voucher/public
</VirtualHost>
```
### 2. Clone this project into your DocumentRoot: 
```shell
git clone https://github.com/SmolyarO/voucher.git
```
### 3. Go to projects root directory
```shell
cd /var/www/voucher
```
### 4. Run `composer install`
### 5. Copy .env.example to .env file and modify it according to your server
### 6. Run several artisan commands:
```shell
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan l5-swagger:publish
```                                      
### 7. Navigate to url that you've specified in apache


## Documentation

### This project use swagger for API documentation

You can get API documentation with request/response payloads by http://your.project.url/api/docs.
For example: http://voucher.dev/api/docs

