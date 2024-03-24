<?php

namespace App\Http\Services;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class MergeRecordsService
{
    public function getDuplicateRecords($type)
    {
        if ($type === 'doctors') {
            return Doctor::select(['id', 'name', 'specialty'])
                ->selectRaw('count(*) as count')
                ->groupBy(['name', 'specialty'])
                ->whereNotNull(['name', 'specialty'])
                ->having('count', '>', 1)
                ->get();
        } else {
            return Clinic::select(['id', 'name', 'address'])
                ->selectRaw('count(*) as count')
                ->groupBy(['name', 'address'])
                ->whereNotNull(['name', 'address'])
                ->having('count', '>', 1)
                ->get();
        }
    }

    public function mergeDuplicateRecords($type)
    {
        if ($type === 'doctors') {
            $duplicateDoctors = $this->getDuplicateRecords($type);

            foreach ($duplicateDoctors as $duplicateDoctor) {
                $duplicateIds = Doctor::select('id')
                ->whereName($duplicateDoctor->name)
                ->whereSpecialty($duplicateDoctor->specialty)
                ->orderBy('id')
                ->where('id', '!=', $duplicateDoctor->id)
                ->get()
                ->pluck('id');

                DB::transaction(function () use ($duplicateIds, $duplicateDoctor) {
                    // Update tests to point to the merge doctor
                    DB::table('tests')
                        ->whereIn('referring_doctor_id', $duplicateIds)
                        ->update(['referring_doctor_id' => $duplicateDoctor->id]);

                    // Delete duplicate doctors
                    Doctor::whereIn('id', $duplicateIds)->delete();
                });
            }
        } else {
            $duplicateClinics = $this->getDuplicateRecords($type);

            foreach ($duplicateClinics as $duplicateClinic) {
                $duplicateIds = Clinic::select('id')
                ->whereName($duplicateClinic->name)
                ->whereAddress($duplicateClinic->address)
                ->orderBy('id')
                ->where('id', '!=', $duplicateClinic->id)
                ->get()
                ->pluck('id');

                DB::transaction(function () use ($duplicateIds, $duplicateClinic) {
                    // Update doctors to point to the merge clinic
                    DB::table('doctors')
                        ->whereIn('clinic_id', $duplicateIds)
                        ->update(['clinic_id' => $duplicateClinic->id]);

                    // Delete duplicate clinics
                    Clinic::whereIn('id', $duplicateIds)->delete();
                });
            }
        }
    }
}
