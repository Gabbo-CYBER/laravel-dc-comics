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

        Schema::create('comics', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');
            $table->text('thumb');
            $table->float('price', 4, 2)->unsigned();
            $table->string('series');
            $table->date('sale_date');
            $table->string('type');

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
        Schema::dropIfExists('comics');
    }
};