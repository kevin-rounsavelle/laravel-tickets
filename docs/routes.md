# Application Routes Reference

## Public

| Route | Purpose |
|---|---|
| `/kb` | Knowledge Base landing page |
| `/kb/{seo_link}` | View Knowledge Base article |
| `/tickets/view/{token}` | Secure ticket access |
| `/login` | Login |
| `/register` | Registration |

## Customers

| Route | Purpose |
|---|---|
| `/dashboard` | Customer dashboard |
| `/tickets/create` | Create support ticket |
| `/tickets/{id}` | View ticket |
| `/profile` | User profile |

## Team Members

| Route | Purpose |
|---|---|
| `/admin/assigned-tickets` | Assigned ticket queue |
| `/admin/tickets/{id}` | Ticket response and management |

## Administrators

| Route | Purpose |
|---|---|
| `/admin/tickets` | Ticket administration |
| `/admin/users` | User management |
| `/admin/kb` | Knowledge Base management |
| `/admin/kb/categories` | KB category management |

## Integrations

| Route | Purpose |
|---|---|
| `POST /webhooks/inbound-email` | Email reply processing webhook |
