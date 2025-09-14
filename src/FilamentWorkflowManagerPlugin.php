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
            ->resources(config('filament-workflow-manager.resources'))
            ->pages(config('filament-workflow-manager.pages'));
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
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}