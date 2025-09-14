# Changelog

All notable changes to `filament-workflow-manager` will be documented in this file.

## 2.0.0 - 2024-XX-XX

### Major Changes
- **BREAKING**: Updated to support Filament v3
- **BREAKING**: Requires PHP 8.0+ and Laravel 10.0+
- **BREAKING**: Changed plugin registration method - now requires `FilamentWorkflowManagerPlugin::make()` in panel provider

### Migrated Components
- Updated ServiceProvider to use Plugin pattern instead of PluginServiceProvider
- Migrated all form and table components to v3 syntax
- Updated resource pages to use new header actions pattern
- Updated Livewire components for v3 notification and event dispatching
- Updated relation managers to use new v3 interfaces
- Updated custom pages to use new table builder pattern

### Enhanced Features
- Improved plugin configuration system
- Better integration with Filament v3 panel system
- Updated documentation with v3 requirements and setup instructions

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
