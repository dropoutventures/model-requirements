<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\PageFactory;
use DropoutVentures\ModelRequirements\Traits\HasRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Page extends Model
{
    use HasFactory;
    use HasRequirements;

    protected $guarded = [];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PageFactory::new();
    }
}
