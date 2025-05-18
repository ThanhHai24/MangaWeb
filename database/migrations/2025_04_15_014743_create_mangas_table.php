<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('author')->nullable();
            $table->string('artist')->nullable();
            $table->string('status')->default('ongoing'); // 'ongoing', 'completed', 'hiatus'
            $table->year('release_year')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // người đăng manga
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mangas');
    }

};
