<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kb_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('meta_description')->nullable();
            $table->string('seo_link')->unique();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->longText('article_content');
            $table->integer('article_active')->default(1);
            $table->text('date_added')->nullable();
            $table->text('date_modified')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kb_articles');
    }
};
