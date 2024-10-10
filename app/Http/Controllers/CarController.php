<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function fetchEmployees() {
        $client = new Client();
        $response = $client->get('http://127.0.0.1:8000/employees');
        return json_decode($response->getBody(), true);
    }

    public function showCar($car_id) {
        $car = Car::find($car_id);
        $employees = $this->fetchEmployees();
        $employee = collect($employees)->firstWhere('id', $car->employee_id);
        return view('carshow', compact('car', 'employee'));
    }

    public function addCar(Request $request) {
        try {
            DB::beginTransaction();
            $car = new Car();
            $car->type = $request->type;
            $car->license_plate = $request->license_plate;
            $car->employee_id = $request->employee_id;
            $car->save();
            DB::commit();
            return redirect()->route('add_car')->with(['success' => 'Car added successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    public function showAddCarForm() {
        $employees = $this->fetchEmployees();
        return view('add_car', compact('employees'));
    }

    public function addCarToEmployee(Request $request) {
        $client = new Client();
        $response = $client->post('http://127.0.0.1:8001/add_car', [
            'form_params' => [
                'type' => $request->type,
                'license_plate' => $request->license_plate,
                'employee_id' => $request->employee_id,
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
}
