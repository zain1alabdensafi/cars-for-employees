<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ETLJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */

     public function handle()
{
    try {
        $employees = DB::connection('mysql2')->table('employees')->get();
        $departments = DB::connection('mysql2')->table('departments')->get();
        $jobs = DB::connection('mysql2')->table('jobs')->get();
        $products = DB::connection('mysql2')->table('products')->get();
        $orders = DB::connection('mysql2')->table('orders')->get();
        $cars = DB::connection('mysql')->table('cars')->get();
        $mergedData = collect();

        foreach ($employees as $employee) {
            $car = $cars->firstWhere('employee_id', $employee->id);
            $employeeOrders = $orders->where('employee_id', $employee->id);
            $department = $departments->firstWhere('id', $employee->department_id);
            $job = $jobs->firstWhere('id', $employee->job_id);
            

            if ($employeeOrders->isEmpty()) {
                $mergedData->push([
                    'employee_id' => $employee->id,
                    'employee_first_name' => $employee->first_name,
                    'employee_last_name' => $employee->last_name,
                    'employee_email' => $employee->email,
                    'employee_hiredate' => $employee->hiredate,
                    'employee_salary' => $employee->salary,
                    'employee_comissions' => $employee->comissions,
                    'department_id' => $employee->department_id,
                    'department_name' => $department ? $department->department_name : null,
                    'job_id' => $employee->job_id,
                    'job_name' => $job ? $job->job_name : null,
                    'role_id' => $employee->role_id,
                    'car_type' => $car ? $car->type : null,
                    'car_license_plate' => $car ? $car->license_plate : null,
                    'product_id' => null,
                    'product_name' => null,
                    'quantity' =>  null,
                    'year' => null,
                    'month' => null,
                    'day' => null,
                    'amount' => null,
                    'status' => null,
                    'min_salary' => $job ? $job->min_salary : null,
                    'max_salary' => $job ? $job->max_salary : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                foreach ($employeeOrders as $order) {
                    $product = $products->firstWhere('id', $order->product_id);
                    $mergedData->push([
                        'employee_id' => $employee->id,
                        'employee_first_name' => $employee->first_name,
                        'employee_last_name' => $employee->last_name,
                        'employee_email' => $employee->email,
                        'employee_hiredate' => $employee->hiredate,
                        'employee_salary' => $employee->salary,
                        'employee_comissions' => $employee->comissions,
                        'department_id' => $employee->department_id,
                        'department_name' => $department ? $department->department_name : null,
                        'job_id' => $employee->job_id,
                        'job_name' => $job ? $job->job_name : null,
                        'role_id' => $employee->role_id,
                        'car_type' => $car ? $car->type : null,
                        'car_license_plate' => $car ? $car->license_plate : null,
                        'product_id' => $order->product_id,
                        'product_name' => $product ? $product->product_name : null,
                        'quantity' => $product ? $product->quantity : null,
                        'year' => date('Y', strtotime($order->order_date)),
                        'month' => date('m', strtotime($order->order_date)),
                        'day' => date('d', strtotime($order->order_date)),
                        'amount' => $order->amount,
                        'status' => $order->status,
                        'min_salary' => $job ? $job->min_salary : null,
                        'max_salary' => $job ? $job->max_salary : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        try {
            DB::connection('mysql_dw')->table('dw_employees_cars')->truncate();
            DB::connection('mysql_dw')->table('dw_employees_cars')->upsert(
                $mergedData->toArray(),
                ['employee_id', 'sale_date'],
                ['employee_first_name', 'employee_last_name', 'employee_email', 'employee_hiredate', 'employee_salary', 'employee_comissions', 'department_id', 'department_name', 'job_id', 'job_name', 'role_id', 'car_type', 'car_license_plate', 'product_id', 'product_name', 'quantity', 'year', 'month', 'day', 'amount', 'status', 'min_salary','max_salary','created_at','updated_at']
            );
            echo "Data inserted/updated successfully!";
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

     











     //----------------------------------------------------------------
//      public function handle()
// {
//     try {
//         $employees = DB::connection('mysql2')->table('employees')->get();
//         $cars = DB::connection('mysql')->table('cars')->get();
//         $orders = DB::connection('mysql2')->table('orders')->get();
//         $mergedData = collect();

//         foreach ($employees as $employee) {
//             $car = $cars->firstWhere('employee_id', $employee->id);
//             $employeeOrders = $orders->where('employee_id', $employee->id);

//             if ($employeeOrders->isEmpty()) {
                
//                 $mergedData->push([
//                     'employee_id' => $employee->id,
//                     'employee_first_name' => $employee->first_name,
//                     'employee_last_name' => $employee->last_name,
//                     'employee_email' => $employee->email,
//                     'employee_hiredate' => $employee->hiredate,
//                     'employee_salary' => $employee->salary,
//                     'employee_comissions' => $employee->comissions,
//                     'car_type' => $car ? $car->type : null,
//                     'car_license_plate' => $car ? $car->license_plate : null,
//                     'sale_date' => null,
//                     'year' => null,
//                     'month' => null,
//                     'day' => null,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             } else {
//                 foreach ($employeeOrders as $order) {
//                     $mergedData->push([
//                         'employee_id' => $employee->id,
//                         'employee_first_name' => $employee->first_name,
//                         'employee_last_name' => $employee->last_name,
//                         'employee_email' => $employee->email,
//                         'employee_hiredate' => $employee->hiredate,
//                         'employee_salary' => $employee->salary,
//                         'employee_comissions' => $employee->comissions,
//                         'department_id'=> $employee->department_id,
//                         'car_type' => $car ? $car->type : null,
//                         'car_license_plate' => $car ? $car->license_plate : null,
//                         'product_id' => $order->product_id,
//                         'year' => date('Y', strtotime($order->order_date)),
//                         'month' => date('m', strtotime($order->order_date)),
//                         'day' => date('d', strtotime($order->order_date)),
//                         'created_at' => now(),
//                         'updated_at' => now(),
//                     ]);
//                 }
//             }
//         }

//         try {
//             DB::connection('mysql_dw')->table('dw_employees_cars')->truncate();
//             DB::connection('mysql_dw')->table('dw_employees_cars')->upsert(
//                 $mergedData->toArray(),    
//                 ['employee_id', 'sale_date'], 
//                 ['employee_first_name', 'employee_last_name', 'employee_email', 'employee_hiredate', 'employee_salary', 'employee_comissions', 'car_type', 'car_license_plate', 'year', 'month', 'day', 'updated_at'] // الأعمدة التي يجب تحديثها
//             );
//             echo "Data inserted/updated successfully!";
//         } catch (\Exception $e) {
//             dd($e->getMessage());
//         }

//     } catch (\Exception $e) {
//         return $e->getMessage();
//     }
// }


     


//     public function handle()
// {
//     try {
//         $employees = DB::connection('mysql2')->table('employees')->get();
//         $cars = DB::connection('mysql')->table('cars')->get();
//         $orders = DB::connection('mysql2')->table('orders')->get();

//         // دمج البيانات
//         $mergedData = collect();

//         foreach ($employees as $employee) {
//             $car = $cars->firstWhere('employee_id', $employee->id);
//             $employeeOrders = $orders->where('employee_id', $employee->id);

//             foreach ($employeeOrders as $order) {
//                 $mergedData->push([
//                     'employee_id' => $employee->id, // تضمين الحقل employee_id
//                     'employee_first_name' => $employee->first_name,
//                     'employee_last_name' => $employee->last_name,
//                     'employee_email' => $employee->email,
//                     'sale_date' => $order->order_date,
//                     'year' => date('Y', strtotime($order->order_date)),
//                     'month' => date('m', strtotime($order->order_date)),
//                     'day' => date('d', strtotime($order->order_date)),
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }
//         }

//         try {
//             DB::connection('mysql_dw')->table('employees_with_sales')->truncate();
//             DB::connection('mysql_dw')->table('employees_with_sales')->upsert(
//                 $mergedData->toArray(),    
//                 ['employee_id', 'sale_date'], // الأعمدة التي يجب تحديثها
//                 ['employee_first_name', 'employee_last_name', 'employee_email', 'year', 'month', 'day', 'updated_at'] // الأعمدة التي يجب تحديثها
//             );
//             echo "Data inserted/updated successfully!";
//         } catch (\Exception $e) {
//             dd($e->getMessage());
//         }

//     } catch (\Exception $e) {
//         return $e->getMessage();
//     }
// }

    
    



















//     public function handle()
// {
//     try {
//         $employees = DB::connection('mysql2')->table('employees')->get();
//         $cars = DB::connection('mysql')->table('cars')->get();

//         // دمج البيانات
//         $mergedData = $employees->map(function ($employee) use ($cars) {
//             $car = $cars->firstWhere('employee_id', $employee->id);
//             return [
//                 'employee_first_name' => $employee->first_name,
//                 'employee_last_name' => $employee->last_name,
//                 'employee_email' => $employee->email,
//                 'employee_hiredate' => $employee->hiredate,
//                 'employee_salary' => $employee->salary,
//                 'employee_comissions' => $employee->comissions,
//                 'car_type' => $car ? $car->type : null,
//                 'car_license_plate' => $car ? $car->license_plate : null,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         });

//         try {
//             DB::connection('mysql_dw')->table('dw_employees_cars')->truncate();
//             DB::connection('mysql_dw')->table('dw_employees_cars')->upsert(
//                 $mergedData->toArray(),    
//                 ['employee_first_name', 'employee_last_name', 'employee_email', 'employee_hiredate', 'employee_salary', 'employee_comissions', 'car_type', 'car_license_plate', 'updated_at'] // الأعمدة التي يجب تحديثها
//             );
//             echo "Data inserted/updated successfully!";
//         } catch (\Exception $e) {
//             dd($e->getMessage());
//         }

//     } catch (\Exception $e) {
//         return $e->getMessage();
//     }
// }

     
    }    


//php artisan queue:work

    //php artisan tinker
    //use App\Jobs\ETLJob;
//ETLJob::dispatch();
//php artisan serve --host=127.0.0.1 --port=8001  
//php artisan migrate:refresh --path=/database/migrations/2024_08_05_215057_create_dw_employees_cars_table.php
