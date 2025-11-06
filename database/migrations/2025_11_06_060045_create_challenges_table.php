<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('challenge_type', ['daily', 'weekly', 'monthly', 'special'])->default('daily');
            $table->text('task_description');
            $table->integer('points_reward')->default(0);
            $table->integer('duration_days')->default(1);
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('challenge_type');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('challenges');
    }
};
