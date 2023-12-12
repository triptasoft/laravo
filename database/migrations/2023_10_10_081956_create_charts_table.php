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
        Schema::create('charts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chart_title')->nullable();
            $table->string('chart_type')->nullable();
            $table->string('report_type')->nullable();
            $table->string('model')->nullable();
            $table->string('group_by_field')->nullable();
            $table->string('relationship_name')->nullable();
            
            $table->integer('parent_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('charts');
    }
};
