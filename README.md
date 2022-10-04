# Example for Laracasts Email issue

https://laracasts.com/discuss/channels/laravel/laravel-9-a-copy-of-the-letter-to-the-client-does-not-arrive-through-phpmailer

## Installation

~~~shell
git clone https://github.com/rodrigopedra/laracasts-issue-email.git
cd laracasts-email
cp .env.example .env
php artisan key:generate
php artisan serve
~~~

- Visit http://127.0.0.1:8000/
- Click `send email`

The project uses the `log` driver for the e-mail and shows the first log lines upon sending
