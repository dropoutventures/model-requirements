
# Laravel Model Requirements

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dropoutventures/model-requirements.svg?style=for-the-badge)](https://packagist.org/packages/dropoutventures/model-requirements)
![GitHub last commit (branch)](https://img.shields.io/github/last-commit/dropoutventures/model-requirements/main?style=for-the-badge)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/dropoutventures/model-requirements/run-tests?label=tests&style=for-the-badge)](https://github.com/dropoutventures/model-requirements/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/dropoutventures/model-requirements/Check%20&%20fix%20styling?label=code%20style&style=for-the-badge)](https://github.com/dropoutventures/model-requirements/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)


With this package you can assign requirements to models based on their relationships. Requirements should be used where you are expecting some sort of Setting to be saved. The Requirement model can be expanded to add other fields like if the rquirement is optional, what type of input the field should be, and more.

**Examples**
- Add a Requirement to a Page using a specific Integration's Action
- Add a Requirement to a Brand using a specific Theme
- Add a Requirement to an Input if you are using a specific Integration
- Add a Requirement to a Page if that page has a specific Input

## Installation

You can install the package via composer:

```bash
composer require dropoutventures/model-requirements
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="model-requirements-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="model-requirements-config"
```

This is the contents of the default config file:

```php
return [
    // Currently There Is No Config
];
```
## Usage

### Owns Requirements

Use the `OwnsRequirements` Trait on Models that will be the parent and create requirements.

**/Models/Integration.php**
```php
class Integration extends Model
{
    use OwnsRequirements;
    
    public function team(): BelongsTo
    { ... }
    
    public function actions(): HasMany
    { ... }
}
```

```php
Integration::factory(['name' => 'Twilio'])
    ->for($team)
    ->has(
        Action::factory(['name' => 'Send SMS'])
    )
    ->has(
        Requirement::factory(['label' => 'API Key', 'field' => 'api'])
            ->hasModels([
                'model_type' => Team::class,
                'relationships' => ['funnels','pages','actions','integration'],
            ])
    )
    ->has(
        Requirement::factory(['label' => 'Verification SID', 'field' => 'sid'])
            ->hasModels([
                'model_type' => Funnel::class,
                'relationships' => ['pages','actions','integration'],
            ])
    )
    ->has(
        Requirement::factory(['label' => 'From Number', 'field' => 'from_num'])
            ->hasModels([
                'model_type' => Page::class,
                'relationships' => ['actions','integration'],
            ])
    )
    ->has(
        Requirement::factory(['label' => 'Phone Validation', 'field' => 'validation'])
            ->hasModels([
                'model_type' => Input::class,
                'match' => ['required' => true, 'type' => InputType::Phone],
                'pivot' => true,
                'relationships' => ['actions','integration'],
            ])
    )
    ->create();
```

### Has Requirements

Use the `HasRequirements` Trait on Models that will receive the requirements.

**/Models/Page.php**
```php
class Page extends Model
{
    use HasRequirements;
    
    public function funnel(): BelongsTo
    { ... }
    
    public function actions(): BelongsToMany
    { ... }
    
    public function inputs(): BelongsToMany
    { ... }
}
```
**/Seeders/FunnelPageSeeder.php**
```php
$funnel = Funnel::factory()
    ->for($team)
    ->has(
        Page::factory()
            ->has(
                Input::factory(['type'=>InputType::Phone, 'required'=>true])
                    ->for($team)
            )
    )
    ->has(Page::factory())
    ->has(Page::factory())
    ->create();

$funnel->pages->first()->actions()->attach(Action::firstWhere('name', 'Send SMS'));
```
**/Controllers/FunnelPageController.php**
```php
return $funnel->requirements;
/*
Illuminate\Database\Eloquent\Collection {
  all: [
    App\Models\Requirement {
      ...
      label: "API Key",
      field: "api",
      requiredModel: App\Models\ModelRequirement {
        ...
      },
    },
  ]
}
*/
```
```php
return $funnel->pages->first()->requirements;
/*
Illuminate\Database\Eloquent\Collection {
  all: [
    App\Models\Requirement {
      ...
      label: "From Number",
      field: "from_num",
      requiredModel: App\Models\ModelRequirement {
        ...
      },
    },
  ]
}
*/
```
```php
return $funnel->pages->first()->inputs->first()->requirements;
/*
Illuminate\Database\Eloquent\Collection {
  all: [
    App\Models\Requirement {
      ...
      label: "Phone Validation",
      field: "validation",
      requiredModel: App\Models\ModelRequirement {
        ...
      },
    },
  ]
}
*/
```

## TODO List
- [x] Enum Value Support
- [x] Pivot Relationship Support
- [ ] Relationship By Class Names
- [ ] Require Another Model Instead of Parent

## Credits

- [jjjrmy](https://github.com/jjjrmy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
