<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('parent'); // NOTE: Can Also Be On Theme
            #
            $table->string('label');
            $table->string('field')->nullable();
            // TODO: $table->nullableMorphs('model'); // NOTE: The Relationship ID That's Required
            #
            $table->boolean('isRelationship')->default(false);
            #
            $table->timestamps();
            #
            $table->unique(['parent_type','parent_id','field','field_value']);
        });

        Schema::create('model_requirements', function (Blueprint $table) {
            $table->id();
            #
            $table->foreignId('requirement_id');
            $table->string('model_type'); // NOTE: Targeted Model
            #
            $table->json('relationships')->nullable(); // Relationship To?
            $table->json('match')->nullable(); // NOTE: Additional Attribute Matching
            #
            $table->unique(['requirement_id','model_class']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirements');
        Schema::dropIfExists('model_requirements');
    }
};
