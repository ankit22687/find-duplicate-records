<?php

namespace App\Http\Controllers;

use App\Http\Requests\MergeRecordRequest;
use App\Http\Services\MergeRecordsService;
use Exception;

class MergeRecordsController extends Controller
{
    public $mergeRecordService;

    public function __construct(MergeRecordsService $mergeRecordService)
    {
        $this->mergeRecordService = $mergeRecordService;
    }

    public function findDuplicateRecords($type)
    {
        $duplicateRecords = $this->mergeRecordService->getDuplicateRecords($type);

        return view('duplicate_records.view', compact('duplicateRecords', 'type'));
    }

    public function mergeDuplicateRecords(MergeRecordRequest $request)
    {
        $type = $request->type;

        try {
            $this->mergeRecordService->mergeDuplicateRecords($type);

            return redirect(route('doctors.index'))->with('status', ucfirst($request->type).' merged successfully');
        } catch (Exception $e) {
            return redirect(route('doctors.index'))->with('error', ucfirst($request->type).' merge failed, please contact site admin');
        }
    }
}
