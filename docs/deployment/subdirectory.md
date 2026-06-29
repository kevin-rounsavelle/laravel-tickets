# Subdirectory Deployment

The application supports:

`https://example.com/support`

Configure:

```env
APP_URL=https://example.com/support
ASSET_URL=https://example.com/support
LIVEWIRE_SUBDIRECTORY=/support
```

Clear cache:

```bash
php artisan config:clear
```

Subdirectory deployments require correct web server alias and rewrite configuration.
