<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStreams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_streams', function (Blueprint $table) {
            $table->collation = 'utf8_bin';
            $table->charset = 'utf8';
            $table->bigIncrements('no');
            $table->string('real_stream_name', 150)->collation('utf8_bin');
            $table->string('stream_name', 41)->collation('utf8_bin');
            $table->json('metadata')->nullable();
            $table->string('category', 150)->collation('utf8_bin')->nullable();
            $table->unique(['real_stream_name'], 'ix_rsn');
            $table->index('category', 'ix_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_streams');
    }
}
