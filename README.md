
# Laravel Model Requirements

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
    
    public function actions(): HasMany
}
```

```php
Integration::factory(['name' => 'Twilio'])
    ->for($team)
    ->has(
        Action::factory(['name' => '2FA'])
    )
    ->has(
        Requirement::factory(['label' => '2 Factor Authentication', 'field' => '2fa'])
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
                'relationships' => ['team','integrations'],
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
    
    public function actions(): BelongsToMany
}
```

```php
$funnel = Funnel::factory()
    ->for($team)
    ->has(Page::factory())
    ->create();

$funnel->pages->first()->actions()->attach(Action::firstWhere('name', '2FA'));

return $funnel->pages->first()->requirements;
/*
Illuminate\Database\Eloquent\Collection {
  all: [
    App\Models\Requirement {
      ...
      label: "2 Factor Authentication",
      field: "2fa",
      requiredModel: App\Models\ModelRequirement {
        model_type: "App\Models\Page",
        relationships: ['actions','integration'],
        match: null,
      },
    },
  ]
}
*/
```

**/Models/Input.php**
```php
class Input extends Model
{
    use HasRequirements;
    
    protected $casts = [
      'type' => \Enums\InputType::class,
    ];
    
    public function team(): BelongsTo
}
```

```php
$input = Input::factory([
    'label' => 'Checkbox',
    'type' => InputType::Checkbox,
    'required' => true
])
    ->for($team)
    ->create();

return $input->requirements;
/*
Illuminate\Database\Eloquent\Collection {
  all: [
    App\Models\Requirement {
      ...
      label: "Phone Validation",
      field: "validation",
      requiredModel: App\Models\ModelRequirement {
        model_type: "App\Models\Input",
        relationships: ['team','integrations'],
        match: null,
      },
    },
  ]
}
*/
```

## TODO List
- [x] Enum Value Support
- [ ] Relationship By Class Names
- [ ] Require Another Model Instead of Parent

## Credits

- [jjjrmy](https://github.com/jjjrmy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
