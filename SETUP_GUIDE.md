# Laravel POS Application Setup Guide

## Prerequisites
- WAMP Server installed and running
- PHP 8.2+ 
- MySQL/MariaDB database
- Composer dependencies already installed (vendor folder exists)

## Step 1: Configure Apache Virtual Host

1. Copy the `pos.conf` file to your WAMP Apache configuration directory:
   ```
   C:\wamp64\bin\apache\apache2.4.xx\conf\extra\httpd-vhosts.conf
   ```
   OR add the contents of `pos.conf` to your `httpd-vhosts.conf` file.

2. Make sure the virtual hosts configuration is enabled in `httpd.conf`:
   ```
   # Uncomment this line
   Include conf/extra/httpd-vhosts.conf
   ```

3. Restart Apache through WAMP control panel.

## Step 2: Configure Hosts File

1. Run `setup_hosts.bat` as Administrator to add the domain mapping:
   - Right-click on `setup_hosts.bat`
   - Select "Run as administrator"

2. Alternatively, manually edit `C:\Windows\System32\drivers\etc\hosts` and add:
   ```
   127.0.0.1 pos.local
   127.0.0.1 www.pos.local
   ```

## Step 3: Database Configuration

1. Create a MySQL database for the POS application (e.g., `pos_db`)

2. Update your `.env` file with database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pos_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Run migrations (if not already done):
   ```
   php artisan migrate --force
   ```

## Step 4: Application Key

Ensure your application has a valid key:
```
php artisan key:generate
```

## Step 5: Access the Application

After completing all steps, access your application at:
- **Primary URL**: http://pos.local
- **Alternative URL**: http://www.pos.local
- **Localhost URL**: http://localhost/pos/public

## Step 6: Optional - Run Seeders

If you want sample data:
```
php artisan db:seed
```

## Troubleshooting

1. **403 Forbidden Error**: Check Apache directory permissions
2. **500 Internal Server Error**: Check Laravel storage permissions:
   ```
   php artisan storage:link
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```

3. **Database Connection Error**: Verify database credentials in `.env`

4. **Virtual Host Not Working**: Check Apache error logs in `C:\wamp64\logs`

## File Structure
- `pos.conf` - Apache virtual host configuration
- `setup_hosts.bat` - Windows hosts file updater
- Application files are in `c:/wamp64/www/pos/`

## Default Access
The application should now be accessible without using `php artisan serve` through:
- http://pos.local (preferred)
- http://localhost/pos/public (fallback)
