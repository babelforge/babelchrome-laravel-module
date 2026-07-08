# Development

Navigation: [Previous: Usage](01-usage.md) | [README](README.md)

The manifest declares:

```json
{
  "runtime": {
    "type": "php-web",
    "entrypoint": "public/index.php",
    "processIsolation": true
  }
}
```

Process isolation prevents Laravel framework classes from colliding with the ExtensionHost Symfony classes.

Run quality checks with:

```bash
composer qa
```

Build the production zip from the meta workspace root:

```bash
./tools/dev2prod.sh laravel-module
```

Navigation: [Previous: Usage](01-usage.md) | [README](README.md)
