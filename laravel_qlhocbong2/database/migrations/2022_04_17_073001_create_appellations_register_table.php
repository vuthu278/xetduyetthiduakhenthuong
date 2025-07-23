<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppellationsRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appellations_register', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('appellation_id')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('certification')->nullable();
            $table->string('phone')->nullable();
            $table->string('code')->nullable();
            $table->string('file')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('time_process')->nullable();
            $table->tinyInteger('is_suggest')->default(0);
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
        Schema::dropIfExists('appellations_register');
    }
}
