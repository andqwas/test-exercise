<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('task_id');

            $table->index('employee_id', 'employee_tasks_employee_id_index');
            $table->index('task_id', 'employee_tasks_task_id_index');

            $table->foreign('employee_id', 'employee_tasks_employee_id_fk')->references('id')->on('employees');
            $table->foreign('task_id', 'employee_tasks_task_id_fk')->references('id')->on('tasks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_tasks');
    }
};
