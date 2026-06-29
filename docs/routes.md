# Routes Reference

## Public

- `/login` - Login
- `/register` - Registration
- `/kb` - Knowledge Base
- `/tickets/view/{token}` - Secure ticket access

## Public Users

- `/dashboard` - Customer dashboard
- `/tickets/create` - Create ticket
- `/tickets/{id}` - View ticket

## Team Members

- `/admin/assigned-tickets` - Assigned tickets
- `/admin/tickets/{id}` - Ticket management

## Administrators

- `/admin/users`
- `/admin/kb`
- `/admin/kb/categories`

## Integrations

- `POST /webhooks/inbound-email`
