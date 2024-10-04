<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('path');              // Movie file path or URL
            $table->string('name');              // Movie name
            $table->text('description');         // Description of the movie
            $table->string('photo');             // Photo or thumbnail URL
            $table->integer('progress_time')->default(0);  // Progress in seconds
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');  // Reference to category
            $table->timestamps();  // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }

};
