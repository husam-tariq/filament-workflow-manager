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
            ->pages(config('filament-workflow-manager.pages', []));
            
        // Add custom styles if configured
        $styles = config('filament-workflow-manager.styles', []);
        if (!empty($styles)) {
            foreach ($styles as $style) {
                $panel->viteTheme($style);
            }
        }
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