<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('route');
            $table->string('og_type')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('online')->default(0);

            $table->json('og_title')->nullable();
            $table->json('og_description')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
        });
    }
};
