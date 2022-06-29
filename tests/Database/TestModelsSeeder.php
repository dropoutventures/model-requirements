<?php

namespace DropoutVentures\ModelRequirements\Tests\Database;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Models\Action;
use DropoutVentures\ModelRequirements\Tests\Models\Brand;
use DropoutVentures\ModelRequirements\Tests\Models\enums\InputType;
use DropoutVentures\ModelRequirements\Tests\Models\Funnel;
use DropoutVentures\ModelRequirements\Tests\Models\Input;
use DropoutVentures\ModelRequirements\Tests\Models\Integration;
use DropoutVentures\ModelRequirements\Tests\Models\Page;
use DropoutVentures\ModelRequirements\Tests\Models\Team;
use DropoutVentures\ModelRequirements\Tests\Models\Theme;
use Illuminate\Database\Seeder;

class TestModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Team
        $team = Team::factory(['name' => 'DropoutVentures'])->create();

        // Other Teams
        Integration::factory()
            ->for(Team::factory())
            ->has(
                Requirement::factory(['label' => 'Validation', 'field' => 'email'])
                    ->hasModels([
                        'model_type' => Input::class,
                        'match' => ['required' => true, 'type' => InputType::Email],
                        'relationships' => ['team','integrations'],
                    ])
            ) // Requirement: Validation [Input:Email->Team->Integrations]
            ->create();

        Theme::factory()
            ->for(Team::factory())
            ->has(
                Requirement::factory(['label' => 'Color 4', 'field' => 'color4'])
                    ->hasModels(['model_type' => Brand::class,'relationships' => ['theme']])
            ) // Requirement: Color4 [Brand->Theme]
            ->create();

        // Theme
        Theme::factory(['name' => 'Two Settings'])
            ->for($team)
            ->has(
                Requirement::factory(['label' => 'Color 1', 'field' => 'color1'])
                    ->hasModels(['model_type' => Brand::class,'relationships' => ['theme']])
            ) // Requirement: Color1 [Brand->Theme]
            ->has(
                Requirement::factory(['label' => 'Color 2', 'field' => 'color2'])
                    ->hasModels(['model_type' => Brand::class,'relationships' => ['theme']])
            ) // Requirement: Color2 [Brand->Theme]
            ->create();
        Theme::factory(['name' => 'One Setting'])
            ->for($team)
            ->has(
                Requirement::factory(['label' => 'Color 3', 'field' => 'color3'])
                    ->hasModels(['model_type' => Brand::class,'relationships' => ['theme']])
            ) // Requirement: Color3 [Brand->Theme]
            ->create();

        Integration::factory(['name' => 'Twilio'])
            ->for($team)
            ->has(
                Action::factory(['name' => '2FA'])
            ) // Action: TwoFactorAuthentication
            ->has(
                Requirement::factory(['label' => '2FA', 'field' => '2fa'])
                    ->hasModels([
                        'model_type' => Page::class,
                        'relationships' => ['actions','integration'],
                    ])
            ) // Requirement: 2FA [Page->Actions->Integrations]
            ->has(
                Requirement::factory(['label' => 'Validation', 'field' => 'phone'])
                    ->hasModels([
                        'model_type' => Input::class,
                        'match' => ['required' => true, 'type' => InputType::Phone],
                        'relationships' => ['team','integrations'],
                    ])
            ) // Requirement: Validation [Input:Phone->Team->Integrations]
            ->create();

        Integration::factory(['name' => 'Send Data'])
            ->for($team)
            ->has(
                Action::factory(['name' => 'Do Something'])
            ) // Action: TwoFactorAuthentication
            ->has(
                Requirement::factory(['label' => 'Campaign ID', 'field' => 'campaign'])
                    ->hasModels([
                        'model_type' => Funnel::class,
                        'relationships' => ['pages','actions','integration'],
                    ])
            ) // Requirement: 2FA [Page->Actions->Integrations]
            ->has(
                Requirement::factory(['label' => 'Input ID', 'field' => 'input'])
                    ->hasModels([
                        'model_type' => Input::class,
                        'pivot' => true,
                        'relationships' => ['actions','integration'],
                    ])
            ) // Requirement: 2FA [Page->Actions->Integrations]
            ->create();

        // Global Brand Requirements
        Requirement::factory(['label' => 'Logo', 'field' => 'logo'])
            ->hasModels(['model_type' => Brand::class])
            ->create();

        // Global Input Requirements
        Requirement::factory(['label' => 'CSS Class', 'field' => 'classes'])
            ->hasModels(['model_type' => Input::class])
            ->create();
        Requirement::factory(['label' => 'Error Message', 'field' => 'error'])
            ->hasModels(['model_type' => Input::class, 'match' => ['required' => true]])
            ->create();
        Requirement::factory(['label' => 'Images', 'field' => 'images'])
            ->hasModels(['model_type' => Input::class, 'match' => ['type' => 'checkbox']])
            ->create();
        Requirement::factory(['label' => 'Auto Submit', 'field' => 'auto_submit'])
            ->hasModels(['model_type' => Input::class, 'match' => ['type' => 'checkbox','required' => true]])
            ->create();
    }
}
