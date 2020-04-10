<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->boolean('mondays')->default(0);
            $table->boolean('tuesdays')->default(0);
            $table->boolean('wednesdays')->default(0);
            $table->boolean('thursdays')->default(0);
            $table->boolean('fridays')->default(0);
            $table->boolean('saturdays')->default(0);
            $table->boolean('sundays')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('events');
    }

}
