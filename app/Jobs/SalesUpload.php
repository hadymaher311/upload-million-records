<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SalesUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $csv;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csv)
    {
        $this->csv = $csv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::connection()->getpdo()->exec("LOAD DATA LOCAL INFILE '" . $this->csv . "' INTO TABLE sales FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' (`Region`, `Country`, `Item Type`, `Sales Channel`, `Order Priority`, `Order Date`, `Order ID`, `Ship Date`, `Units Sold`, `Unit Price`, `Unit Cost`, `Total Revenue`, `Total Cost`, `Total Profit`, `created_at`, `updated_at`)");
    }
}
