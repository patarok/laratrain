<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('godot_id');
            $table->bigInteger('estragon_id');
            $table->string('title');
            $table->text('excerpt');
            $table->text('body');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['godot_id', 'estragon_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
