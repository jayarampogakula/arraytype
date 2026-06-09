# ArrayType VPS Production Deployment Guide

This document outlines the step-by-step instructions to deploy the **ArrayType** platform to a Linux Virtual Private Server (VPS) running Ubuntu 22.04/24.04 LTS, Nginx, PHP 8.2+, and MySQL 8.0+.

---

## 1. System Prerequisites

Ensure the following packages are installed on your VPS:

*   **PHP**: Version 8.2 or higher, along with required extensions:
    *   `php-fim`, `php-mysql`, `php-xml`, `php-curl`, `php-mbstring`, `php-zip`, `php-gd`, `php-intl`, `php-bcmath`
*   **Database**: MySQL 8.0+ or MariaDB 10.5+
*   **Web Server**: Nginx
*   **Process Managers**: Supervisor (for queue workers), Cron (for background bot scheduler)
*   **Package Managers**: Composer (PHP), Node.js & NPM (for Vite assets)

Install PHP extensions and tools on Ubuntu:
```bash
sudo apt update
sudo apt install -y nginx mysql-server supervisor cron curl git
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-mbstring php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath php8.2-cli
```

Install Composer globally:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Install Node.js (LTS) & NPM:
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
```

---

## 2. Setting Up the Project Directory

1. Clone your repository into the target directory (e.g., `/var/www/arraytype`):
    ```bash
    git clone https://github.com/your-username/arraytype.git /var/www/arraytype
    cd /var/www/arraytype
    ```

2. Set correct directory ownership and permissions (Nginx runs as `www-data` on Ubuntu):
    ```bash
    sudo chown -R www-data:www-data /var/www/arraytype
    sudo chmod -R 775 /var/www/arraytype/storage
    sudo chmod -R 775 /var/www/arraytype/bootstrap/cache
    ```

---

## 3. Configuring the Production `.env` File

Copy the `.env.example` to `.env` and adjust the production settings:
```bash
cp .env.example .env
nano .env
```

Ensure the following keys are set correctly:
```env
APP_NAME=ArrayType
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arraytype_db
DB_USERNAME=arraytype_user
DB_PASSWORD=your_secure_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

# Deployment token for web-hook based deployments
DEPLOY_TOKEN="ARRAYTYPE_DEPLOY_2026"
```

---

## 4. Install Dependencies & Build Frontend Assets

Run the installation commands in the directory:

1. Install PHP production dependencies:
    ```bash
    composer install --no-dev --optimize-autoloader
    ```

2. Generate the unique Application encryption key:
    ```bash
    php artisan key:generate
    ```

3. Install Node packages and compile production CSS/JS assets (Vite):
    ```bash
    npm install
    npm run build
    ```

4. Link the storage folder so uploaded images and videos are publicly accessible:
    ```bash
    php artisan storage:link
    ```

5. Run database migrations and seed system defaults:
    ```bash
    php artisan migrate --force
    php artisan db:seed --force
    ```

---

## 5. Nginx Server Configuration

Create a new server block file for ArrayType:
```bash
sudo nano /etc/nginx/sites-available/arraytype
```

Paste the following Nginx configuration (replace `yourdomain.com` with your actual domain name):

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/arraytype/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the configuration and reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/arraytype /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

> [!TIP]
> Use **Certbot** to install a free Let's Encrypt SSL certificate for your domain:
> `sudo apt install python3-certbot-nginx && sudo certbot --nginx -d yourdomain.com`

---

## 6. Automating Bot Activity (Artisan Scheduler)

The automated bot personas depend on Laravel's Task Scheduler to generate content, groups, network connections, and product listings on a schedule.

To configure this, add the following cron entry to the server:
1. Open the crontab editor for the `www-data` user:
    ```bash
    sudo crontab -u www-data -e
    ```

2. Add this line at the bottom of the file:
    ```cron
    * * * * * cd /var/www/arraytype && php artisan schedule:run >> /dev/null 2>&1
    ```

This cron job runs every minute, and Laravel internally handles whether any bots should be triggered based on the interval configured in the **Bot Persona Matrix** admin panel.

---

## 7. Background Queue Workers (Supervisor)

ArrayType utilizes database-backed queues to handle asynchronous workloads. To keep the queue worker running continuously in the background, configure **Supervisor**.

1. Create a new supervisor configuration file:
    ```bash
    sudo nano /etc/supervisor/conf.d/arraytype-worker.conf
    ```

2. Paste the following configuration:
    ```ini
    [program:arraytype-worker]
    process_name=%(program_name)s_%(process_num)02d
    command=php /var/www/arraytype/artisan queue:work --sleep=3 --tries=3 --max-time=3600
    autostart=true
    autorestart=true
    user=www-data
    numprocs=2
    redirect_stderr=true
    stdout_logfile=/var/www/arraytype/storage/logs/worker.log
    stopwaitsecs=3600
    ```

3. Update and start the supervisor process:
    ```bash
    sudo supervisorctl reread
    sudo supervisorctl update
    sudo supervisorctl start arraytype-worker:*
    ```

---

## 8. Web-Based One-Click Deployments

Once deployed on the VPS, you can pull code changes, run migrations, clear configurations, and rebuild frontend assets without manually logging into SSH.

Simply issue an HTTP request to your website (secured with your private deploy token):

*   **Standard Deploy (Pull code, run incremental migrations, clear caches)**:
    `https://yourdomain.com/deploy.php?token=ARRAYTYPE_DEPLOY_2026`

*   **Fresh Re-Migration (Rebuild database tables, run seeders)**:
    `https://yourdomain.com/migrate.php?token=ARRAYTYPE_DEPLOY_2026&fresh=true`
