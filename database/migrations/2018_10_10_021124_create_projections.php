<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projections', function (Blueprint $table) {
            $table->collation = 'utf8_bin';
            $table->charset = 'utf8';
            $table->bigIncrements('no');
            $table->string('name', 150)->collation('utf8_bin');
            $table->json('position')->nullable();
            $table->json('state')->nullable();
            $table->string('status', 28)->collation('utf8_bin');
            $table->string('locked_until', 26)->collation('utf8_bin')->nullable();
            $table->unique(['name'], 'ix_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projections');
    }
}
