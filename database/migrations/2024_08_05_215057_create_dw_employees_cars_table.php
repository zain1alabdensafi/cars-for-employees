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
    Schema::connection('mysql_dw')->dropIfExists('dw_employees_cars');

    Schema::connection('mysql_dw')->create('dw_employees_cars', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id')->nullable();
        $table->string('employee_first_name')->nullable();
        $table->string('employee_last_name')->nullable();
        $table->string('employee_email')->unique()->nullable();
        $table->date('employee_hiredate')->nullable();
        $table->unsignedInteger('employee_salary')->nullable();
        $table->decimal('employee_comissions')->nullable();
        $table->unsignedInteger('department_id')->nullable();
        $table->string('department_name')->nullable();
        $table->unsignedInteger('job_id')->nullable();
        $table->string('job_name')->nullable();
        $table->unsignedInteger('role_id')->nullable();
        $table->unsignedInteger('product_id')->nullable();
        $table->string('product_name')->nullable();
        $table->unsignedInteger('quantity')->nullable();
        $table->unsignedInteger('year')->nullable();
        $table->unsignedInteger('month')->nullable();
        $table->unsignedInteger('day')->nullable();
        $table->unsignedInteger('amount')->nullable();
        $table->boolean('status')->nullable();
        $table->string('car_type')->nullable();
        $table->unsignedInteger('car_license_plate')->nullable();
        $table->unsignedInteger('min_salary')->nullable();
        $table->unsignedInteger('max_salary')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::connection('mysql_dw')->dropIfExists('dw_employees_cars');
}
};
