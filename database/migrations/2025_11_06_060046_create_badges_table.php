<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('criteria_type', ['points', 'challenges', 'quizzes', 'streak', 'special'])->default('points');
            $table->integer('criteria_value')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('criteria_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('badges');
    }
};
