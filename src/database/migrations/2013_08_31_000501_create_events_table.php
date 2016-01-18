<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('event_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('locale');
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('venue')->nullable();
            $table->text('address');
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['event_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_translations');
        Schema::drop('events');
    }
}
