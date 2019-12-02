<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Reports\ProductsReport;
use App\Jobs\EmailProductReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $timestamp = Carbon::now()->getTimestamp();
        (new ProductsReport())->store('/reports/export_master' . $timestamp . '.xlsx')->chain([
            new EmailProductReport(storage_path().'/app/reports/export_master' . $timestamp . '.xlsx')
        ]);
        return redirect()->back();
    }
}
