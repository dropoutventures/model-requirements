<?php

namespace DropoutVentures\ModelRequirements\Traits;

use DropoutVentures\ModelRequirements\Models\ModelRequirement;
use DropoutVentures\ModelRequirements\Models\Requirement;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

trait HasRequirements
{
    protected static function bootHasRequirements(): void
    {
        static::retrieved(function ($model) {
            $model->makeHidden(['requirement_type']);
        });
    }

    public function requirementType(): Attribute
    {
        return Attribute::make(
            get: fn () => __CLASS__
        );
    }

    /**
     * @return MorphToMany
     */
    public function requirementsRelationship(): MorphToMany
    {
        return $this->morphToMany(
            Requirement::class,
            'model',
            'model_requirement',
            'model_type', // $pivot->model_type : $this->requirement_type
            'requirement_id', // $pivot->requirement_id : $requirement->id
            'requirement_type', // $this->requirement_type : $pivot->model_type
            'id' // $requirement->id : $pivot->requirement_id
        )
            ->using(ModelRequirement::class)
            ->as('requiredModel')
            ->withPivot('pivot', 'relationships', 'match');
    }

    /**
     * @return Collection
     */
    public function getRequirementsAttribute(): Collection
    {
        return $this->requirementsRelationship->filter(
            function ($requirement) {

                // GUARD: Reject If Any Attributes Doesn't Match
                if ($requirement->requiredModel->match
                    && $requirement->requiredModel->match->isNotEmpty()
                    && ! $requirement->requiredModel->match
                        ->every(
                            fn ($value, $attribute) =>
                            (($attributeValue = $this->{$attribute}) instanceof \BackedEnum)
                                ? $attributeValue->value === $value
                                : $attributeValue === $value
                        )
                ) {
                    return false;
                }

                // GUARD: Return If No Relationship OR No Parent
                if (
                    (
                        ! $requirement->requiredModel->relationships
                        || $requirement->requiredModel->relationships->isEmpty()
                    )
                    || empty($requirement->parent)
                ) {
                    return true;
                }

                // GUARD: Reject If Relationships Cannot Be Loaded
                try {
                    $relationship = (
                        $requirement->requiredModel->pivot
                        ? $this->pivot->pivotParent->load($requirement->requiredModel->relationships->implode('.'))
                        : $this->load($requirement->requiredModel->relationships->implode('.'))
                    );
                } catch (\Exception $e) {
                    return false;
                }

                $relationship = $requirement->requiredModel->relationships->reduce(
                    fn ($return, $relation) =>
                        match (true) {
                            $return instanceof Model
                                => $return->{$relation},
                            $return instanceof Collection
                                => $return->pluck($relation)->flatten()->unique('id'),
                            default => false,
                        },
                    $relationship
                );

                return match (true) {
                    $relationship instanceof Collection
                        => $relationship->contains('id', $requirement->parent->id),
                    $relationship instanceof Model
                        => $relationship->is($requirement->parent),
                    default => false,
                };
            }
        );
    }
}
