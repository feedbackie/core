This package contains the core functionality of Feedbackie that is common to both the community and cloud versions. 

Installing using composer:

```
composer require feedbackie/core
```

Then add the FeedbackieCorePlugin plugin to the Filament plugin list.

```
    ->plugins([
         \Feedbackie\Core\FeedbackieCorePlugin::make()
    ]);
```

After this download GeoIP database:

```
php artisan app:download-geoip-db
```
