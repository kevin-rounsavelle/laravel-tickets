# Production Deployment

Before deployment:

- Set APP_ENV=production
- Disable APP_DEBUG
- Configure mail
- Configure storage
- Build assets

Run:

```bash
php artisan optimize
npm run build
```
