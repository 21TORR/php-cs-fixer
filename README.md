PHP-CS-Fixer Config for 21TORR projects
=======================================

> 📚 [**Read the docs**](https://21torr-docs.fly.dev/docs/php/tooling/php-cs-fixer/)

Installation
------------

You should install this package using the [composer-bin-plugin]. So first add the composer plugin, then install this bundle:

```bash
composer req --dev bamarni/composer-bin-plugin
composer bin cs-fixer require --dev 21torr/php-cs-fixer
```

Afterwards add the following scripts to your `composer.json`, to always and automatically keep these dependencies up to date:

```json
"scripts": {
    "post-install-cmd": [
        "@composer bin all install --ansi"
    ],
    "post-update-cmd": [
        "@composer bin all update --ansi"
    ]
}
```

Now you should ignore the nested vendor directories in your `.gitignore`:

```
/vendor-bin/*/composer.lock
/vendor-bin/*/vendor
```


Usage
-----

After installation, you can run the tools like this:

```bash
./vendor/bin/php-cs-fixer fix --dry-run --diff --config vendor-bin/cs-fixer/vendor/21torr/php-cs-fixer/.php-cs-fixer.dist.php
```

[composer-bin-plugin]: https://github.com/bamarni/composer-bin-plugin
