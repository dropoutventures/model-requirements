<?php

use DropoutVentures\ModelRequirements\Tests\Database\Seeders\TestModelsSeeder;
use DropoutVentures\ModelRequirements\Tests\Models\Action;
use DropoutVentures\ModelRequirements\Tests\Models\Brand;
use DropoutVentures\ModelRequirements\Tests\Models\enums\InputType;
use DropoutVentures\ModelRequirements\Tests\Models\Funnel;
use DropoutVentures\ModelRequirements\Tests\Models\Input;
use DropoutVentures\ModelRequirements\Tests\Models\Integration;
use DropoutVentures\ModelRequirements\Tests\Models\Page;
use DropoutVentures\ModelRequirements\Tests\Models\Team;
use DropoutVentures\ModelRequirements\Tests\Models\Theme;

test(
    'Integration:Twilio OwnsRequirements -> 2:[Phone,2FA]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $requirements = Integration::firstWhere('name', 'Twilio')->requirements->pluck('field');
        expect($requirements->count())->toEqual(2)
            ->and($requirements->toArray())->toEqualCanonicalizing(['phone','2fa']);
    }
);

test(
    'Input:Phone HasRequirements -> 3:[Classes,Error,Phone]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $input = Input::factory(['label' => 'Phone', 'type' => InputType::Phone, 'required' => true])
            ->for(Team::firstWhere('name', 'DropoutVentures'))
            ->create();

        $requirements = $input->requirements->pluck('field');
        expect($requirements->count())->toEqual(3)
            ->and($requirements->toArray())->toEqualCanonicalizing(['classes','error','phone']);
    }
);

test(
    'Input:Email HasRequirements -> 1:[Classes]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $input = Input::factory(['label' => 'Email', 'type' => InputType::Email])
            ->for(Team::firstWhere('name', 'DropoutVentures'))
            ->create();

        $requirements = $input->requirements->pluck('field');
        expect($requirements->count())->toEqual(1)
            ->and($requirements->toArray())->toEqualCanonicalizing(['classes']);
    }
);

test(
    'Input:Checkbox HasRequirements -> 4:[Classes,Error,Images,Auto_Submit]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $input = Input::factory(['label' => 'Checkbox', 'type' => InputType::Checkbox, 'required' => true])
            ->for(Team::firstWhere('name', 'DropoutVentures'))
            ->create();

        $requirements = $input->requirements->pluck('field');
        expect($requirements->count())->toEqual(4)
            ->and($requirements->toArray())->toEqualCanonicalizing(['classes','error','images','auto_submit']);
    }
);

test(
    'Brand HasRequirements -> 3:[Logo,Color1,Color2]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $brand = Brand::factory(['domain' => 'twosettings.com'])
            ->for(Team::firstWhere('name', 'DropoutVentures'))
            ->for(Theme::firstWhere('name', 'Two Settings'))
            ->create();

        $requirements = $brand->requirements->pluck('field');
        expect($requirements->count())->toEqual(3)
            ->and($requirements->toArray())->toEqualCanonicalizing(['logo','color1','color2']);
    }
);

test(
    'Page+Action HasRequirements -> 1:[2FA]',
    function () {
        $this->seed(TestModelsSeeder::class);

        $funnel = Funnel::factory()
            ->for(Team::firstWhere('name', 'DropoutVentures'))
            ->has(Page::factory())
            ->create();

        $funnel->pages->first()->actions()->attach(Action::firstWhere('name', '2FA'));

        $requirements = $funnel->pages->first()->requirements->pluck('field');
        expect($requirements->count())->toEqual(1)
            ->and($requirements->toArray())->toEqualCanonicalizing(['2fa']);
    }
);
