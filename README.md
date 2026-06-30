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
- User management & role assignment
- Team member assignment
- Email-based ticket replies
- Secure guest ticket access
- File uploads
- Social authentication
- Subdirectory deployment support

---

## Installation

This application is a standard Laravel 13 application using Livewire, Volt, and Tailwind CSS.

### Requirements

Before installing, make sure you have:

- PHP 8.3+
- Composer
- Node.js and npm
- MySQL / MariaDB (or compatible database)
- OpenAI PHP Client (`openai-php/client` composer package)

### Setup

Clone the repository:

```bash
git clone https://github.com/kevin-rounsavelle/laravel-tickets.git
```

Enter the application directory: (or your exact install directory path on your server)

```bash
cd laravel-tickets 
```

Install PHP dependencies:

```bash
composer install
```

Create your environment file:

```bash
cp .env.example .env
```

Configure your database settings in `.env`, then set your mail provider, OAuth credentials (optional), and webhook settings. Then generate the Laravel application key:

```bash
php artisan key:generate
```

Run database migrations and seed demo data:

```bash
php artisan migrate --seed
```

Clear Laravel caches:

```bash
php artisan optimize:clear
```

Create the storage symlink:

```bash
php artisan storage:link
```

Install frontend dependencies and compile assets:

```bash
npm install
npm run build
```

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
- Delete tickets permanently (gated to admins only; automatically cleans up replies and deletes attachments from storage)


---

## Team Member Dashboard

Support team members (agents, role_id = 2) have a dedicated console:

- **Assigned Tickets:** View only tickets specifically assigned to them.
- **Search & Filter:** Search and filter their assigned queue by status.
- **Reply to Customers:** View conversations and post replies to assigned tickets.
- **Restricted Privileges:** Cannot delete tickets or view tickets assigned to other staff.


---

## User Management (Admin Only)

Administrators can manage all accounts on the platform:

- User Directory: View all registered users with pagination, live search (by name/email), and role filters.
- Add New Users: Directly register users with predefined roles. Manually added users are automatically marked as email-verified (`email_verified_at` populated immediately).
- Edit Profiles: Update name, email, and optionally reset/change user passwords.
- Assign Roles: Promote or demote users between *User* (regular customer), *Team Member* (support agent), and *Admin* (full access) using database-driven role IDs.
- Delete Accounts: Permanently remove users from the platform (with built-in protection blocking admins from deleting their own logged-in account).


---

## Knowledge Base (KB)

The platform includes a fully featured Knowledge Base to provide self-service help for customers:

- **Public KB Landing Page:** Clean, searchable interface featuring a top-level category browser with nested articles, and a dedicated "Top 15 Most Popular" cards section based on helpfulness ratings.
- **Helpfulness Ratings:** Customers can upvote or downvote articles ("Was this article helpful?") using a session-secured tracking system to prevent duplicate votes.
- **Categories:** Organize articles into specific topics, complete with custom sort ordering for both categories and their nested articles.
- **Admin KB Management:**
  - Full CRUD operations for KB Articles and Categories.
  - Integrated, self-hosted TinyMCE rich-text editor for article composition.
  - Custom sort ordering to control public display priorities.
  - Toggle publication dates on/off per article.
  - Draft/Active visibility toggles for easy content management.

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
| User Roles | DB-driven `user_roles` lookup table |

### Key PHP (Composer) Dependencies

* **`laravel/framework`** (`^13.0`): The core PHP MVC framework.
* **`livewire/livewire`** (`^3.6`): Framework for building dynamic, reactive interfaces directly in PHP.
* **`livewire/volt`** (`^1.7`): Single-file Livewire components with a declarative API.
* **`laravel/socialite`** (`^5.28`): Package for handling OAuth social logins (Google, Facebook, GitHub).
* **`league/flysystem-aws-s3-v3`** (`^3.35`): AWS S3 integration for remote file/media uploads.
* **`zbateson/mail-mime-parser`** (`^4.0`): Mail MIME parser to decode raw inbound email webhook payloads.
* **`openai-php/laravel`** (`^0.18`): Laravel wrapper for integrating OpenAI API functionality.

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

---

All providers must include a header field called: X-Webhook-Secret
This value must be set as .env variable: INBOUND_WEBHOOK_SECRET

---

Supported payload formats:

Generic JSON:

```json
{
"from_email":"customer@example.com",
"from_name":"Customer",
"body":"Reply text"
}
```

Mailgun:

```
recipient
sender
from
body-plain
```

Postmark:

```
ToFull
FromFull
TextBody
```

Cloudflare

```
recipient
raw
```
### Cloudflare Email Worker Setup

If you are using Cloudflare Email Routing for inbound ticket replies, create an Email Worker that forwards incoming emails to the Laravel webhook endpoint.

After creating the Email Worker, open the code editor and replace the worker code with the following.

**Important:** Update these two values before deploying:

1. Replace:

```
https://yourdomain.com/webhooks/inbound-email
```

with your actual Laravel webhook URL.

If your app is installed in a subdirectory, include it:

```
https://yourdomain.com/folder-name/webhooks/inbound-email
```

2. Replace:

```
X-Webhook-Secret
```

with the same value configured in your Laravel `.env` file:

```env
INBOUND_WEBHOOK_SECRET=xxxxxx-xxxx-xxxx-xxxx-xxxxxxxx
```

Cloudflare Email Worker:

```javascript
export default {
  async fetch(request, env, ctx) {
    return new Response("Inbound Email Worker Running");
  },

  async email(message, env, ctx) {
    try {

      // Entire RFC822 message
      const rawEmail = await new Response(message.raw).text();

      const payload = {
        recipient: message.to,
        raw: rawEmail
      };

      const response = await fetch(
        "https://yourdomain.com/webhooks/inbound-email",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Webhook-Secret": "xxxxxx-xxxx-xxxx-xxxx-xxxxxxxx"
          },
          body: JSON.stringify(payload)
        }
      );

      if (!response.ok) {
        const text = await response.text();

        console.error(
          `Laravel returned ${response.status}: ${text}`
        );

        throw new Error(
          `Webhook failed (${response.status})`
        );
      }

      console.log("Inbound email successfully forwarded.");

    } catch (err) {

      console.error(
        "Cloudflare Email Worker Error:",
        err.stack || err.message
      );

      throw err;
    }
  }
};
```

After saving the worker:

1. Click **Deploy**
2. Return to **Email Routing**
3. Add the worker as the destination for your support reply domain
4. Send a test email to verify the Laravel ticket reply is created
---

### File Upload Configuration to CDN (S3 | Cloudfront)

Set `s3` as the filesystem (upload destination) in `.env`:

```env
FILESYSTEM_DISK=s3
```

Enter your S3 bucket credentials in `.env`:

```env
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

Enter the URL to your S3 bucket or CloudFront distribution domain in `.env` under:

```env
CDN_URL=https://abc123456.cloudfront.net
```

---

# Social Login Setup

Supports:

- Google
- Facebook
- GitHub (Note: If using a GitHub App, the app **must** have **"Email addresses"** selected under *Permissions > Account permissions* in your App settings under *Settings > Developer settings > GitHub Apps > [App Name] > Permissions & Events*)


Generate your domain's social login app credentials through:

- Google Developer Console
- Meta Developer Console
- GitHub Developer Settings (OAuth Apps / GitHub Apps)


Add:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=

GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
```


Callback URLs:

```
{APP_URL}/auth/google/callback

{APP_URL}/auth/facebook/callback

{APP_URL}/auth/github/callback
```

### Missing Email Address Fallback
If a social provider does not provide the user's email address, the user is temporarily redirected to `/auth/collect-email` to supply a valid, unique email address.
- Direct social registration (where email is provided) automatically sets `email_verified_at` to `now()`.
- Social registration where the email is collected manually keeps `email_verified_at` as `null` so they must verify their email.

---

# Google reCAPTCHA Setup

Recommended for registration protection.

Add:

```env
RECAPTCHA_SITE_KEY=

RECAPTCHA_SECRET_KEY=
```

---

## AI Integrations

The system includes built-in AI-assisted tools for administrators and support team members.

### KB Article AI Generator (OpenAI)

Helps create or rewrite customer-facing Knowledge Base articles using custom prompts and existing draft content.

**How it works:**

On the KB Create and Edit pages, administrators can enter a prompt and use the **Generate with OpenAI** button. The system sends the custom instructions and current draft content to OpenAI and returns structured, formatted HTML content ready to insert into the editor.

**Requirements:**

Add your OpenAI API key to your `.env` file:

```env
OPENAI_API_KEY=your_api_key_here
```
---

### Ticket Reply Assistant (Optional)

Provides AI-generated support reply suggestions based on the ticket description and conversation history.

**How it works:**

A button is available next to the ticket reply editor. When used, the ticket history is sent to your configured AI completion provider and a suggested response is generated for the agent to review, edit, or copy.

> **Important:** This feature works best when your Knowledge Base content or ticket-specific documentation has already been ingested into your AI RAG system. This allows the AI provider to generate responses with the proper context.

### Setup & Custom RAG Systems

This feature is completely optional and designed to support custom AI providers.

To enable it, configure your provider details in your `.env` file: The AI_PROVIDER variable cannot be empty if using third party connector code but it can be anything since it is used only as a on/off check for this feature.

```env
AI_PROVIDER=your_provider_name
AI_PROVIDER_API_KEY=your_api_key_here
AI_PROVIDER_ACCOUNT_ID=your_account_id_here
```

Then create the following custom helper file:

```text
app/Includes/ai_ticket_response.php
```

The file must define the following function:

```php
ai_ticket_response(string $text): string
```

The configured `.env` values are available inside this function and can be used to authenticate and connect to your preferred AI/RAG provider.

This file is intentionally gitignored and not included in the repository, allowing developers to customize the integration with their preferred AI service.

Examples of systems that can be connected include:

- Visperity
- Algolia
- Google Vertex AI
- Other custom AI completion or RAG services

```
```

# Subdirectory Deployment Support

The application supports:

```
https://example.com
```

and:

```
https://example.com/support
```


Livewire requires additional configuration when running behind a domain alias. '/support' is used as an example folder name only. Replace with your actual folder name (alias) on your domain.

---

# Environment Configuration For Subdirectory Installs

Update:

```env
APP_URL=https://example.com/support

ASSET_URL=https://example.com/support

LIVEWIRE_SUBDIRECTORY=/support
```

After modifying your environment configuration, you must clear the configuration cache for changes to take effect:

```bash
php artisan config:clear
```

---

# Recommended Apache Alias Setup For Subdirectory Installs

Example:

```apache
<VirtualHost *:80>
ServerName example.com
DocumentRoot /var/www/example-com/main-site/public
<Directory "/var/www/example-com/main-site/public">
AllowOverride All
</Directory>

Alias /support /var/www/example-com/laravel-app/public
<Directory /var/www/example-com/laravel-app/public>
AllowOverride All
Require all granted
</Directory>

</VirtualHost>
```

---

# SSL Alias Example For Subdirectory Installs

```apache
<VirtualHost *:443>
ServerName example.com
DocumentRoot /var/www/example-com/main-site/public

Alias /support /var/www/example-com/laravel-app/public
<Directory /var/www/example-com/laravel-app/public>
AllowOverride All
Require all granted
</Directory>

SSLEngine On
SSLCertificateFile /etc/pki/tls/certs/example.crt
SSLCertificateKeyFile /etc/pki/tls/private/example.key
</VirtualHost>
```

---

# Update Public .htaccess Example For Subdirectory Installs

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

# Routes

| Route | Description |
|---|---|
| `/dashboard` | Customer ticket dashboard |
| `/tickets/create` | Create ticket |
| `/tickets/{id}` | Authenticated ticket view |
| `/tickets/view/{token}` | Secure guest ticket view |
| `/admin/tickets` | Admin dashboard (tickets list) |
| `/admin/assigned-tickets` | Team member dashboard (assigned tickets list) |
| `/admin/tickets/{id}` | Ticket management & replies (restricted to assigned agent if user is a Team Member) |
| `/admin/users` | Admin user directory |
| `/admin/users/create` | Admin user creation form |
| `/admin/users/{id}/edit` | Admin user edit profile & role |
| `/admin/kb` | Admin KB articles management |
| `/admin/kb/categories` | Admin KB category management |
| `/admin/kb/create` | Admin create KB article |
| `/admin/kb/{id}/edit` | Admin edit KB article |
| `/kb` | Public Knowledge Base landing page |
| `/kb/{seo_link}` | Public Knowledge Base article view |
| `/profile` | User profile |

---

## Production Checklist

Before deploying:

- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Configure database credentials
- [ ] Configure mail provider
- [ ] Configure reCAPTCHA keys (optional)
- [ ] Configure Social Login credentials (if using)
- [ ] Set INBOUND_WEBHOOK_SECRET
- [ ] Run php artisan optimize
- [ ] Run npm run build

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

```
