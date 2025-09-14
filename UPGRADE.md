# Migrating to Filament v3

This guide will help you upgrade from the Filament v2 version of this package to the new v3 version.

## Requirements

Before upgrading, ensure your application meets these requirements:

- **Filament v3**: Your application must be running Filament v3.0 or higher
- **PHP 8.0+**: Minimum PHP version increased to 8.0
- **Laravel 10.0+**: Minimum Laravel version increased to 10.0

## Installation

Update your composer dependency:

```bash
composer update heloufir/filament-workflow-manager
```

## Configuration Changes

### 1. Plugin Registration

The package now uses Filament v3's plugin system. You must register the plugin in your panel provider.

**In your `app/Providers/Filament/AdminPanelProvider.php`:**

```php
use Heloufir\FilamentWorkflowManager\FilamentWorkflowManagerPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->plugins([
            FilamentWorkflowManagerPlugin::make(),
            // ... other plugins
        ]);
}
```

### 2. Remove Old Service Provider Registration

If you previously registered the service provider manually, you can remove it from your `config/app.php` as it's now auto-discovered.

## Breaking Changes

### Navigation Configuration

The navigation properties are now handled through static methods that read from the configuration file. If you were overriding navigation properties directly, ensure your `config/filament-workflow-manager.php` has the correct values:

```php
'navigation_group' => 'Settings',
'navigation_sort' => 1,
'navigation_icon' => 'heroicon-o-collection',
```

### Custom Components

If you extended any of the package's components:

- `WorkflowResource` now uses instance methods for form/table instead of static methods
- Livewire components now use `dispatch()` instead of `emit()` for events
- Notifications now use `Notification::make()` instead of `Filament::notify()`

## No Changes Required

The following should continue to work without modification:

- Your workflow configurations
- Database migrations and models
- Custom views and translations
- Workflow permissions

## Testing Your Migration

After upgrading:

1. Clear your application cache: `php artisan cache:clear`
2. Ensure all workflow resources appear correctly in the admin panel
3. Test creating and editing workflows
4. Verify workflow status transitions work as expected
5. Check that workflow permissions function correctly

## Getting Help

If you encounter issues during migration:

1. Check the [GitHub Issues](https://github.com/heloufir/filament-workflow-manager/issues)
2. Join the [Filament Discord](https://filamentphp.com/discord) and ask in #workflow-manager
3. Review the Filament v3 upgrade guide for general Filament migration issues