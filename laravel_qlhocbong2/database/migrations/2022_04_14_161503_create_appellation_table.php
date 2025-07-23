<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppellationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appellations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('rule')->nullable();
            $table->date('time_start')->nullable();
            $table->date('time_stop')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('appellations');
    }
}
