This package contains the core functionality of Feedbackie that is common to both the community and cloud versions. 

Installing using composer:

```
composer require feedbackie/core
```

Then add the FeedbackieCorePlugin plugin to the Filament plugin list.

```php
    ->plugins([
         \Feedbackie\Core\FeedbackieCorePlugin::make()
    ]);
```

After this download GeoIP database:

```
php artisan app:download-geoip-db
```

Implement UserContact and FilamentUser interfaces in your User model:

```php
use Feedbackie\Core\Contracts\UserContract;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements UserContract, FilamentUser
{
//... 
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
```

Publish package resources:

``` 
php artisan vendor:publish --provider="Feedbackie\Core\Providers\FeedbackieCoreProvider" --tag="assets"

```
