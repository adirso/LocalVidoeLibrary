<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->text('description');
            $table->integer('progress_time')->default(0); // in seconds or minutes
            $table->foreignId('series_id')->constrained()->onDelete('cascade'); // Series reference
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
