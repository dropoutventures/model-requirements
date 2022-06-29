<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Database\factories\ActionFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Action extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function page()
    {
        return $this->belongsToMany(Page::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ActionFactory::new();
    }
}
