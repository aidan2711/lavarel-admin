<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('match_id')->nullable();
            $table->string('league_id')->nullable();
            $table->string('league_name')->nullable();
            $table->string('league_display')->nullable();
            $table->string('home_team')->nullable();
            $table->string('home_flag')->nullable();
            $table->string('visiting_team')->nullable();
            $table->string('visiting_flag')->nullable();
            $table->string('match_type_id')->nullable();
            $table->string('time')->nullable();
            $table->integer('position')->nullable();
            $table->integer('status')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
        
        Schema::create('match_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('slug', 50);
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
        Schema::dropIfExists('events');
        Schema::dropIfExists('match_types');
        Schema::dropIfExists('match_type_events_table');
    }
}