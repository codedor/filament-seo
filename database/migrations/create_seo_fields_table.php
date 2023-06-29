<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->morphs('model');
            $table->string('type');
            $table->string('name');
            $table->longText('content')->nullable();
            $table->boolean('is_translatable');
        });
    }
};
