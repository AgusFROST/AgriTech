<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ndvi', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->float('avg_ndvi')->nullable();
            $table->float('healthy_percentage')->nullable();
            $table->integer('alert_count')->nullable();
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
        Schema::dropIfExists('ndvi');
    }
}
