<?php

namespace Heloufir\FilamentWorkflowManager;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentWorkflowManagerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-workflow-manager';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources(config('filament-workflow-manager.resources', []))
            ->pages(config('filament-workflow-manager.pages', []))
            ->renderHook(
                'panels::styles.after',
                fn () => '<link rel="stylesheet" href="' . asset('css/filament-workflow-manager.css') . '">'
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }
}