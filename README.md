# Laravel 13 Livewire Helpdesk & Email Ticketing System

A modern customer support and helpdesk ticketing platform built with:

- Laravel 13
- Livewire 3
- Livewire Volt
- Tailwind CSS
- Laravel Socialite
- Email-based ticket reply ingestion

Designed for SaaS applications and support teams requiring a complete customer support workflow with:

- User dashboard
- Administrator dashboard
- Team member assignment
- Email-based ticket replies
- Secure guest ticket access
- File uploads
- Social authentication
- Subdirectory deployment support

---

# Features

## User Dashboard

Customers can:

- Create support tickets
- Upload screenshots/files
- View ticket history
- Reply to conversations
- Track ticket status
- Receive email notifications
- Reply directly from email
- Access tickets using secure links without logging in


---

## Admin Dashboard

Support administrators can:

- View all customer tickets
- Search and filter tickets
- View conversations
- Reply to tickets
- Assign tickets to team members
- Reassign tickets
- Manage ticket workflow
- Update ticket statuses
- Monitor incoming email replies


---

## Ticket Status Workflow

Supported statuses:

| Status | Description |
|---|---|
| Open | New ticket waiting for review |
| Assigned | Ticket assigned to a support member |
| In Process | Support member is actively working on the issue |
| Completed | Resolution provided |
| Closed | Ticket completed and archived |


---

## Ticket Submission

Customers can submit tickets with:

- Subject
- Description
- File attachments
- Screenshots

Attachment support:

- Up to 5MB per file


---

## Email Notifications

The system supports:

- Ticket creation confirmations
- Ticket status updates
- New reply notifications
- Email conversation threading

Closed tickets do not send status notification emails.

---

## Secure Ticket Links

Customers can access tickets without logging in using secure token URLs.

Example:

```
/tickets/view/{uuid-token}
```

These links allow customers to:

- View ticket conversations
- Reply securely
- Continue conversations from email


---

## Email Based Ticket Replies

Customers can reply directly through email.

Example:

```
reply+{ticket-token}@yourdomain.com
```

The system automatically:

- Matches replies to tickets
- Creates new replies
- Maintains conversation history


Supported providers:

- Cloudflare Email Routing
- Mailgun
- Postmark


---

# Technology Stack

| Component | Technology |
|---|---|
| Framework | Laravel 13 |
| UI | Livewire 3 + Volt |
| CSS | Tailwind CSS |
| Authentication | Laravel Auth + Socialite |
| Build Tool | Vite |
| Database | Laravel Supported Databases |
| Email | Webhook Based Processing |


---

# Requirements

- PHP 8.3+
- Composer
- Node.js
- npm


---

# Quick Start

Clone the repository:

```bash
cd support-tickets
```

Install dependencies:

```bash
composer install
```

Create environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Run migrations and seed data:

```bash
php artisan migrate:fresh --seed
```

Create storage link:

```bash
php artisan storage:link
```

Install frontend dependencies:

```bash
npm install
```

Build assets:

```bash
npm run build
```

Start Laravel:

```bash
php artisan serve
```

Visit:

```
http://localhost:8000
```

---

# Demo Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@support.local | SampleUser12345# |
| Agent | agent@support.local | SampleUser12345# |
| Customer | user1@example.com | SampleUser12345# |


Additional users are created during seeding.

---

# Email Configuration

Default development mode:

```env
MAIL_MAILER=log
```

Emails will be written to:

```
storage/logs
```

For production configure:

- SMTP
- Mailgun
- Postmark
- Other Laravel mail providers


---

# Email Reply Webhook

Configure your provider to send:

```
POST /webhooks/inbound-email
```

Supported payload formats:

Generic JSON:

```json
{
"reply_token":"TOKEN",
"from_email":"customer@example.com",
"from_name":"Customer",
"body":"Reply text"
}
```

Mailgun:

```
recipient
sender
body-plain
```

Postmark:

```
ToFull
FromFull
TextBody
```


---

# Social Login Setup

Supports:

- Google
- Facebook


Install credentials through:

- Google Developer Console
- Meta Developer Console


Add:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```


Callback URLs:

```
{APP_URL}/auth/google/callback

{APP_URL}/auth/facebook/callback
```

---

# Google reCAPTCHA Setup

Recommended for registration protection.

Add:

```env
RECAPTCHA_SITE_KEY=

RECAPTCHA_SECRET_KEY=
```

---

# Subdirectory Deployment Support

The application supports:

```
https://example.com
```

and:

```
https://example.com/support
```


Livewire requires additional configuration when running behind a domain alias.

---

# Recommended Apache Alias Setup

Example:

```apache
<VirtualHost *:80>
ServerName example.com
DocumentRoot /var/www/example-com/main-site/public
<Directory "/var/www/example-com/main-site/public">
AllowOverride All
</Directory>

Alias /folder-name /var/www/example-com/laravel-app/public
<Directory /var/www/example-com/laravel-app/public>
AllowOverride All
Require all granted
</Directory>

</VirtualHost>
```

---

# SSL Alias Example

```apache
<VirtualHost *:443>
ServerName example.com
DocumentRoot /var/www/example-com/main-site/public

Alias /folder-name /var/www/example-com/laravel-app/public
<Directory /var/www/example-com/laravel-app/public>
AllowOverride All
Require all granted
</Directory>

SSLEngine On
SSLCertificateFile /etc/pki/tls/certs/example.crt
SSLCertificateKeyFile /etc/pki/tls/private/example.key
</VirtualHost>
```
```

---

# Update Public .htaccess

Edit:

```
public/.htaccess
```

Add:

```apache
RewriteEngine On
RewriteBase /support/
```


---

## Environment Setup

Copy:

.env.example

to:

.env

Then configure your database, mail provider, OAuth credentials, and webhook settings.

# Environment Configuration

Update:

```env
APP_URL=https://example.com/support

ASSET_URL=https://example.com/support
```


---

# Livewire Subdirectory Route

Edit:

```
app/Providers/AppServiceProvider.php
```


Add:

```php
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
```


Inside boot():

```php
Livewire::setUpdateRoute(function ($handle) {

return Route::post(
'/support/livewire/update',
$handle
);

});
```


---

# Publish Livewire Config

Run:

```bash
php artisan livewire:publish --config
```


Add:

```php
'asset_url' => env('APP_URL') . '/livewire/livewire.js',
```


Clear cache:

```bash
php artisan optimize:clear
```

---

# Routes

| Route | Description |
|---|---|
| `/dashboard` | Customer ticket dashboard |
| `/tickets/create` | Create ticket |
| `/tickets/{id}` | Authenticated ticket view |
| `/tickets/view/{token}` | Secure guest ticket view |
| `/admin/tickets` | Admin dashboard |
| `/admin/tickets/{id}` | Ticket management |
| `/profile` | User profile |


---

# License

This project is licensed under the MIT License.

The MIT License is a permissive open-source license that allows you to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the software, provided that the original copyright notice and license text are included.

```
MIT License

Copyright (c) 2026 Your Name or Company Name

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

# Credits

Built with Laravel, Livewire, Volt, Tailwind CSS, and modern PHP practices.
