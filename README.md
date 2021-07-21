# Laravel Permission

This repository is based on [spatie/laravel-permission](https://github.com/spatie/laravel-permission)

The difference is that we can add titles and descriptions to roles and permissions.

## Installation
```shell
composer require gnepiew/laravel-permission
```

```shell
php artisan permission:install
```

## Usage

```php
use Gnepiew\Permission\Models\Role;
use Gnepiew\Permission\Models\Permission;

// Create a role
$role = Role::create([
    'name'        => 'admin',
    'title'       => 'Administrator',
    'description' => 'The description for this role.'
]);

// Create a permission
$permission = Permission::create([
    'name'        => 'edit articles',
    'title'       => 'Edit Articles',
    'description' => 'The description for this permission.'
]);
```

### Using artisan commands

```shell
php artisan permission:role-create admin
```

```shell
php artisan permission:create "edit articles"
```

#### Via Options

```shell
php artisan permission:create "create articles" --guard=api --title="Create Articles" --description="The description for this permission."
```

```shell
php artisan permission:role-create admin --guard=api --title=Administrator --description="The description for this role." --permissions="create articles|edit articles"
```

#### Via Option Shortcuts

```shell
php artisan permission:create "delete articles" -g api -t "Delete Articles" -d "The description for this permission."
```

```shell
php artisan permission:role-create writer -g api -t Writer -d "The description for this role." -p "create articles|edit articles"
```
