<?php

namespace DropoutVentures\ModelRequirementSettings\Traits;

use DropoutVentures\ModelRequirementSettings\Models\ModelRequirement;
use DropoutVentures\ModelRequirementSettings\Models\Requirement;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasRequirements
{
    protected static function bootHasRequirements(): void {
        static::retrieved(function ($model) {
            $model->makeHidden(['requirement_type']);
            $model->requirement_type = __CLASS__;
        });
    }

    /**
     * @return MorphToMany
     */
    public function requirementsRelationship(): MorphToMany
    {
        return $this->morphToMany(Requirement::class, 'model',
            'model_requirements',
            'model_type', // $pivot->model_type : $this->requirement_type
            'requirement_id', // $pivot->requirement_id : $requirement->id
            'requirement_type', // $this->requirement_type : $pivot->model_type
            'id' // $requirement->id : $pivot->requirement_id
        )
            ->using(ModelRequirement::class)
            ->as('requiredModel')
            ->withPivot('relationships', 'match');
    }

    /**
     * @return Collection
     */
    public function requirements(): Collection
    {
        return $this->requirementsRelationship->filter(
            function($requirement) {
                // GUARD: Filter If Any Attributes Doesn't Match
                if (! $requirement->requiredModel->match
                        ->every(fn($value, $attribute) => $this->{$attribute}===$value)
                ) { return false; }
                // GUARD: Return If No Relationship OR No Parent
                if (
                    $requirement->requiredModel->relationships->isEmpty()
                    || empty($requirement->parent)
                ) { return true; }

                // Relationships: ['class'=>'method','class'=>'method'] ...
                $relationship = $requirement->requiredModel->relationships->reduce(fn($return, $relation) =>
                    match (true) {
                        $return instanceof Model
                            => $return->{$relation},
                        $return instanceof Collection
                            => $return->pluck($relation)->flatten()->unique('id'),
                        default => false,
                    }, $this->load($requirement->requiredModel->relationships->implode('.'))
                );

                return match (true) {
                    $relationship instanceof Collection
                        => $relationship->contains('id', $requirement->parent->id),
                    $relationship instanceof Model
                        => $relationship->is($requirement->parent->id),
                    default => false,
                };
            }
        );
    }
}
