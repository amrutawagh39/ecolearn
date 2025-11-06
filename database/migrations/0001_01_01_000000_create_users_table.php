<?php
// database/migrations/0001_01_01_000000_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // EcoLearn specific fields
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
            $table->string('school_name');
            $table->string('grade_level');
            $table->integer('eco_points')->default(0);
            $table->integer('level')->default(1);
            $table->string('avatar')->nullable();

            $table->rememberToken();
            $table->timestamps();

            // Indexes
            $table->index(['role']);
            $table->index(['eco_points']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
