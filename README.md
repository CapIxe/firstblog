# Blog engine created on Symfony 3
========================

# Installation
--------------
```bash
$ git clone git@github.com:CapIxe/firstblog.git
```

# Running

```bash
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
$ php bin/console assets:install --symlink
$ php bin/console assetic:dump
$ php bin/console server:run
```

Check http://localhost:8000/ to start


