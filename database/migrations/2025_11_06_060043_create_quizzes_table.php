<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('questions_count')->default(0);
            $table->integer('time_limit_minutes')->nullable();
            $table->integer('passing_score')->default(60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['lesson_id']);
            $table->index(['is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
