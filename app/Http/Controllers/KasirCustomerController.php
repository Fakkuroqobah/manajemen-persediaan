<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use DataTables;

class KasirCustomerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Customer::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns([''])
                ->make(true);
        }

        return view('kasir_customer.kasir_customer');
    }
}