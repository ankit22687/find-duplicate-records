<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Clinic;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('clinic')->withCount('tests')->orderBy('updated_at', 'desc')->paginate(100);

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $clinics = Clinic::all();

        return view('doctors.create', compact('clinics'));
    }

    public function store(StoreDoctorRequest $request)
    {
        Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('clinic');

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $clinics = Clinic::all();

        return view('doctors.edit', compact('doctor', 'clinics'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }
}
