<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->integer('points')->default(1); // default 1 point per question
    });
}

public function down()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropColumn('points');
    });
}

};
