<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtableModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtable_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->text('description');
            $table->string('unit');
            $table->unsignedBigInteger('interchangeable_with_id')->nullable();
            $table->string('note')->nullable();
            $table->string('airtable_id')->unique();
            $table->foreign('interchangeable_with_id')
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
        Schema::dropIfExists('airtable_models');
    }
}
