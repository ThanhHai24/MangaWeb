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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->float('chapter_number', 8, 2); // Hỗ trợ số chapter dạng 1.5, 2.5
            $table->longText('images')->nullable(); // Lưu trữ đường dẫn ảnh dưới dạng JSON
            $table->text('content')->nullable(); // Nội dung hoặc ghi chú chapter
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['manga_id', 'chapter_number']);
            $table->unique(['manga_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};
