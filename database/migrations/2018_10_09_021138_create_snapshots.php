<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapshots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->collation = 'utf8_bin';
            $table->charset = 'utf8';
            $table->string('aggregate_id', 150)->collation('utf8_bin');
            $table->string('aggregate_type', 150)->collation('utf8_bin');
            $table->integer('last_version');
            $table->string('created_at', 26)->collation('utf8_bin');
            $table->binary('aggregate_root');
            $table->unique(['aggregate_id'], 'ix_aggregate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snapshots');
    }
}