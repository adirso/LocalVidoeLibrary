<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('path');              // Series file path or URL
            $table->string('name');              // Series name
            $table->text('description');         // Description of the series
            $table->string('photo');             // Photo or thumbnail URL
            $table->integer('season')->default(1);  // Season number
            $table->integer('episode')->default(1); // Episode number
            $table->integer('progress_time')->default(0);  // Progress in seconds
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');  // Reference to category
            $table->timestamps();  // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('series');
    }

};
