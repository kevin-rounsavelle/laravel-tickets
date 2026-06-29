# Troubleshooting

## Livewire Problems

Clear caches:

```bash
php artisan optimize:clear
```

Rebuild assets:

```bash
npm run build
```

## Email Reply Issues

Check:

- webhook URL
- secret
- provider payload
- Laravel logs
