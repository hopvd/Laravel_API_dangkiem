<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends AdminController
{
    public function __construct()
    {
        parent::__contruct();

    }

    public function index()
    {
        $data['title'] = 'Danh sach phuong tien';
        $data['breadcrumb'] = "Phuong tien";
        $vehicles = DB::table('vehicles')->paginate(15);
        $data['vehicles'] = $vehicles;
        return view('admin.vehicle.index', $data);
    }

    public function show($id)
    {
        $data['title'] = 'Chi tiet phuong tien';
        $data['breadcrumb'] = "Phuong tien";
        $data['vehicle'] = Vehicle::all()->find($id);
        return view('admin.vehicle.show', $data);
    }

    public function create()
    {
        $data['title'] = 'Them phuong tien';
        $data['breadcrumb'] = "Phuong tien";
        return view('admin.vehicle.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'license_plate' => 'required',
            'location' => 'required',
            'produce_year' => 'required',
            'company' => 'required',
            'purpose_to_use' => 'required',
            'name' => 'required',
            'owner_id' => 'required',
        ]);

        Vehicle::create($data);
        return redirect(route('vehicle.index'));
    }

    public function update(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);

        $data = $request->validate([
            'license_plate' => 'required',
            'location' => 'required',
            'produce_year' => 'required',
            'company' => 'required',
            'purpose_to_use' => 'required',
            'name' => 'required',
            'owner_id' => 'required',
        ]);

        $vehicle->license_plate = $data['license_plate'];
        $vehicle->location = $data['location'];
        $vehicle->produce_year = $data['produce_year'];
        $vehicle->company = $data['company'];
        $vehicle->name = $data['name'];
        $vehicle->purpose_to_use = $data['purpose_to_use'];
        $vehicle->owner_id = $data['owner_id'];
        $vehicle->save();

    }

    public function delete($id){
        // Tìm đến đối tượng muốn xóa
        $vehicle = Vehicle::findOrFail($id);

        $vehicle->delete();
        echo"success delete vehicle";
    }
}
