# Development

Navigation: [Previous: Usage](01-usage.md) | [README](README.md)

The manifest declares:

```json
{
  "runtime": {
    "type": "process-web",
    "command": "php",
    "args": ["-S", "127.0.0.1:{{ port }}", "-t", "public", "public/index.php"],
    "readyUrl": "http://127.0.0.1:{{ port }}/health"
  }
}
```

The Laravel app runs in its own module-owned PHP process, so framework classes do not collide with BabelChrome Browser internals or other modules.

Run quality checks with:

```bash
composer qa
```

Build the production zip from the meta workspace root:

```bash
./tools/dev2prod.sh laravel-module
```

Navigation: [Previous: Usage](01-usage.md) | [README](README.md)
