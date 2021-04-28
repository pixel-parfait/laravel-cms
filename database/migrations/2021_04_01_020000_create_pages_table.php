<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('index')->unique();
            $table->bigInteger('cover_id')->unsigned()->nullable();
            $table->boolean('draft')->default(0);
            $table->timestamps();

            $table->foreign('cover_id')->references('id')->on('media')->onDelete('set null');
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id('id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->text('content')->nullable();

            $table->bigInteger('page_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['page_id', 'locale']);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
}
