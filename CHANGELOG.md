# Changelog

All notable changes to `filament-workflow-manager` will be documented in this file.

## 2.0.0 - 2024

### Breaking Changes
- **Filament v3 Compatibility**: Updated package to support Filament v3
- **Plugin Registration**: Changed from automatic resource registration to plugin-based registration
- **API Changes**: Updated all classes to use Filament v3 API patterns

### Changes
- Updated composer dependency from `filament/filament: ^2.13` to `filament/filament: ^3.0`
- Replaced `PluginServiceProvider` with `PackageServiceProvider` and created dedicated `FilamentWorkflowManagerPlugin`
- Updated resource form/table method signatures for v3 compatibility
- Changed page action methods from `getActions()` to `getHeaderActions()`
- Updated Livewire components to use new notification API (`Notification::make()` instead of `Filament::notify()`)
- Changed event emission from `$this->emit()` to `$this->dispatch()`
- Updated relation managers to extend `RelationManager` instead of specific typed managers
- Replaced deprecated `Card` component with `Section` component
- Updated icon from `heroicon-o-collection` to `heroicon-o-rectangle-stack`

### Migration Guide
1. Update your composer requirement to use version `^2.0`
2. Add the plugin to your Filament panel provider:
   ```php
   ->plugins([
       FilamentWorkflowManagerPlugin::make(),
   ])
   ```
3. Remove the old resources/pages configuration from your panel provider if you were manually registering them

## 1.1.8 - 2022-07-07

- Permisions
  - Add workflow permissions to manage users having access to different workflow transitions

## 1.1.7 - 2022-07-07

- Design enhancement
  - Add dashed border design to end workflow statuses

## 1.1.6 - 2022-07-07

- End of workflow
  - Add boolean to workflow status to detect the end of workflow

## 1.1.5 - 2022-07-05

- Bug-fix
  - Wrong new_status returned on event details object, fixed.

## 1.1.4 - 2022-07-05

- Add events

## 1.1.3 - 2022-07-05

- History system

## 1.1.2 - 2022-07-05

- Add translations (fr / ar)
  - Add translations (fr / ar) and add compatibility for RTL design

## 1.1.1 - 2022-07-04

- Fix typo

## 1.1 - 2022-07-04

- First stable version

## 1.0.7 - 2022-07-04

- Update views 
  - Bug-fixing

## 1.0.6 - 2022-07-04

- Update livewire components 
  - Bug-fixing

## 1.0.5 - 2022-07-04

- Add livewire components 
  - Configure package livewire components

## 1.0.4 - 2022-07-04

- Add views 
  - Add package views to configuration

## 1.0.3 - 2022-07-04

- Update translations 
  - Update translations path in views, resources, ...

## 1.0.2 - 2022-07-04

- Add translations 
  - Adding translation file (for `en` default language)

## 1.0.1 - 2022-07-04

- Structure enhancement 
  - Some changes on package structure

## 1.0 - 2022-07-04

- First released version
