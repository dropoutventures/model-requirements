<?php

namespace DropoutVentures\ModelRequirements\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Requirement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label', 'field'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'isRelationship' => 'boolean',
    ];

    /**
     * @return MorphTo
     */
    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function models(): HasMany
    {
        return $this->hasMany(ModelRequirement::class);
    }
}
