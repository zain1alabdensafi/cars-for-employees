<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Jobs\ETLJob;

class ETLController extends Controller
{
    public function runETL()
    {
        // تشغيل وظيفة ETL
        ETLJob::dispatch();
        return response()->json(['message' => 'ETL job dispatched successfully!']);
    }
}

