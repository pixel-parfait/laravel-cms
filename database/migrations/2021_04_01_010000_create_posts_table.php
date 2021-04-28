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
            $table->bigInteger('cover_id')->unsigned()->nullable();
            $table->boolean('draft')->default(0);
            $table->timestamps();

            $table->foreign('cover_id')->references('id')->on('media')->onDelete('set null');
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id('id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->text('content')->nullable();
            $table->string('excerpt', 255)->nullable();

            $table->bigInteger('post_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['post_id', 'locale']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
    }
}
