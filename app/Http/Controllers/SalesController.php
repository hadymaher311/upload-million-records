<?php

namespace App\Http\Controllers;

use App\Jobs\SalesUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function show()
    {
        return view("sales");
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'csv' => 'required|file|mimes:csv,txt'
        ]);
        // DB::connection()->getpdo()->exec("LOAD DATA LOCAL INFILE '" . storage_path() . "/app/public/sales100.csv" . "' INTO TABLE sales FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' (`Region`, `Country`, `Item Type`, `Sales Channel`, `Order Priority`, `Order Date`, `Order ID`, `Ship Date`, `Units Sold`, `Unit Price`, `Unit Cost`, `Total Revenue`, `Total Cost`, `Total Profit`, `created_at`, `updated_at`)");
        $name = $request->file('csv')->getClientOriginalName();
        $path = $request->file('csv')->storeAs('csvs', $name);
        $path = storage_path() . '/app/' . $path;
        SalesUpload::dispatch($path);
        return back()->with('status', 'Uploaded Successfully!');
    }
}
