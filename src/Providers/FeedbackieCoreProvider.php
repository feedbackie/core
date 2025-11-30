<?php

declare(strict_types=1);

namespace Feedbackie\Core\Providers;

use Feedbackie\Core\Services\GeoipService;
use Feedbackie\Core\Services\MetadataService;
use Feedbackie\Core\Services\SitesStorage;
use Feedbackie\Core\Utils\Colors;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Console\Commands\DownloadGeoIpDatabaseCommand;
use Feedbackie\Core\Http\Livewire\SiteCodeViewer;
use Feedbackie\Core\Http\Livewire\SiteSelector;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Models\Metadata;
use Feedbackie\Core\Models\Report;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Observers\FillUserIdFromSession;
use Feedbackie\Core\Observers\FillUserIdFromSite;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class FeedbackieCoreProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/feedbackie.php', 'feedbackie'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/feedbackie.php' => config_path('feedbackie.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/feedbackie'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../../resources/js' => resource_path('js/vendor/feedbackie'),
        ], 'assets');
        $this->publishes([
            __DIR__ . '/../../resources/css' => resource_path('css/vendor/feedbackie'),
        ], 'assets');


        $this->publishesMigrations([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'feedbackie-core');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'feedbackie-core');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/testing.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DownloadGeoIpDatabaseCommand::class,
            ]);
        }

        Livewire::component(SiteSelector::COMPONENT_NAME, SiteSelector::class);
        Livewire::component(SiteCodeViewer::COMPONENT_NAME, SiteCodeViewer::class);

        Site::observe(FillUserIdFromSession::class);
        Feedback::observe(FillUserIdFromSite::class);
        Report::observe(FillUserIdFromSite::class);
        Metadata::observe(FillUserIdFromSite::class);

        if (FeedbackieConfiguration::isRouteSiteDependent()) {
            FilamentView::registerRenderHook(
                'panels::topbar.start',
                fn(): string => Blade::render('@livewire(\'' . SiteSelector::COMPONENT_NAME . '\')'),
            );
        }

        FilamentColor::register(Colors::getColorsDefinition());

        $this->app->singleton(GeoipService::class, static function () {
            return new GeoipService();
        });
        $this->app->singleton(MetadataService::class, function () {
            return new MetadataService(
                $this->app->get(GeoipService::class),
                $this->app->get(Request::class),
            );
        });
        $this->app->singleton(SitesStorage::class, static function () {
            return new SitesStorage();
        });
    }
}
