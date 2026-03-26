# StewardsCredit — Production Deployment Guide

This document describes every step required to deploy StewardsCredit to a production server.

---

## 1. Server Requirements

| Component | Minimum Version |
|---|---|
| PHP | 7.4+ (8.1 recommended) |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Apache / Nginx | Any current stable |
| mod_rewrite (Apache) | Enabled |
| PHP Extensions | `pdo_mysql`, `mbstring`, `openssl`, `gd`, `curl`, `zip` |

---

## 2. Environment Variables

Set the following environment variables on your server (via `.env`, Apache `SetEnv`, or Nginx `fastcgi_param`). **Never commit these values to Git.**

```bash
# Database — main application
DB_HOST=localhost
DB_NAME=stewards_credit
DB_USER=your_db_user
DB_PASS=your_db_password

# Database — backoffice (can be the same DB)
BO_DB_HOST=localhost
BO_DB_NAME=stewards_credit
BO_DB_USER=your_db_user
BO_DB_PASS=your_db_password

# CodeIgniter environment
CI_ENV=production

# Cron job secret key (used to protect the alerts cron endpoint)
CRON_SECRET_KEY=replace_with_a_long_random_string
```

---

## 3. Database Setup

### 3a. Initial Schema

```bash
mysql -u root -p stewards_credit < .install/stewards.sql
```

### 3b. Production Migrations

Run the migration script to add indexes, foreign keys, the `alerts` table, the `account_attachments` table, and the `trans_type` column:

```bash
mysql -u root -p stewards_credit < .install/migrations/001_production_optimizations.sql
```

---

## 4. File Permissions

```bash
chmod -R 755 /var/www/stewardscredit
chmod -R 777 /var/www/stewardscredit/application/logs
chmod -R 777 /var/www/stewardscredit/application/cache
chmod -R 777 /var/www/stewardscredit/uploads
```

---

## 5. Apache Virtual Host

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/stewardscredit

    # Set CI environment
    SetEnv CI_ENV production

    # Set DB credentials
    SetEnv DB_HOST localhost
    SetEnv DB_NAME stewards_credit
    SetEnv DB_USER your_db_user
    SetEnv DB_PASS your_db_password

    SetEnv CRON_SECRET_KEY replace_with_a_long_random_string

    <Directory /var/www/stewardscredit>
        AllowOverride All
        Require all granted
    </Directory>

    SSLEngine on
    SSLCertificateFile    /etc/letsencrypt/live/yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourdomain.com/privkey.pem
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>
```

---

## 6. Cron Job — Daily Payment Alerts

Add the following to your server's crontab (`crontab -e`):

```cron
# Send due payment alert emails every day at 8:00am
0 8 * * * curl -s "https://yourdomain.com/cron_controller/send_due_payment_alerts?key=YOUR_CRON_SECRET_KEY" >> /var/log/stewards_alerts.log 2>&1
```

Replace `YOUR_CRON_SECRET_KEY` with the value you set in `CRON_SECRET_KEY`.

---

## 7. Email (SMTP) Configuration

Configure SMTP in the admin panel under **Settings → Email Settings**. Recommended providers:

- **Brevo (Sendinblue)** — free tier, reliable for transactional email
- **Mailgun** — developer-friendly, good deliverability
- **Gmail SMTP** — suitable for low-volume (use App Password, not your account password)

---

## 8. Security Checklist

Before going live, verify the following:

- [ ] `CI_ENV` is set to `production` on the server
- [ ] Database credentials are in environment variables, **not** in `database.php`
- [ ] `database.php` is listed in `.gitignore`
- [ ] SSL certificate is installed and HTTP redirects to HTTPS
- [ ] `uploads/` directory is not directly executable (add `.htaccess` to deny PHP execution)
- [ ] Default admin password has been changed
- [ ] Error display is off (automatic when `CI_ENV=production`)
- [ ] Log files are not publicly accessible

### Protect the uploads directory from PHP execution

Create `/var/www/stewardscredit/uploads/.htaccess`:

```apache
<FilesMatch "\.php$">
    Deny from all
</FilesMatch>
```

---

## 9. Post-Deployment Verification

1. Log in as admin and confirm the dashboard loads.
2. Create a test client account and record a deposit — verify the balance is correct.
3. Create a test loan and verify the amortization schedule uses the correct term.
4. Upload a test attachment and verify it appears in the attachments tab.
5. Schedule a test alert and trigger the cron endpoint manually to verify email delivery.
6. Send a test eStatement and verify the email arrives correctly.
7. Attempt to log in with a wrong password 6 times — verify the account is locked for 15 minutes.

---

## 10. Ongoing Maintenance

| Task | Frequency |
|---|---|
| Review `application/logs/` for errors | Weekly |
| Back up the database | Daily (automated) |
| Renew SSL certificate | Auto-renew via Let's Encrypt |
| Review pending transactions | Daily |
| Check cron job log `/var/log/stewards_alerts.log` | Weekly |
