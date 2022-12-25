<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtableModelModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtable_model_model', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dwg_no')->nullable();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('dwg_id');
            $table->string('quantity');
            $table->unsignedBigInteger('child_id');
            $table->string('dwg_ref_no')->nullable();
            $table->string('airtable_id')->unique();
            $table->foreign('parent_id')
                ->references('id')
                ->on('airtable_models');
            $table->foreign('dwg_id')
                ->references('id')
                ->on('airtable_drawings');
            $table->foreign('child_id')
                ->references('id')
                ->on('airtable_models');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airtable_model_model');
    }
}
