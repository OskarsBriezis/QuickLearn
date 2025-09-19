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
    Schema::create('quiz_result_answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('quiz_result_id')->constrained()->onDelete('cascade');
        $table->foreignId('answer_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('quiz_result_answers');
}

};
