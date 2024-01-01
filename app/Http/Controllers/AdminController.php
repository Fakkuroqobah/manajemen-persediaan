<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Admin::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    $btn = `'<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id_admin .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>'`;
                    
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_admin .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'username' => 'required|max:20|unique:tb_admin,username',
            'password' => 'required|max:20'
        ]);

        try {
            $data = Admin::create([
                'nama_admin' => $request->nama,
                'username' => $request->username,
                'password' => bcrypt($request->password)
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Admin::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'username' => 'required|max:20',
            'password' => 'nullable|max:20'
        ]);

        $data = Admin::findOrFail($id);
        $oldPassword = $data->password;
        try {
            $data->update([
                'nama_admin' => $request->nama,
                'username' => $request->username,
                'password' => $request->filled('password') ? bcrypt($request->password) : $oldPassword
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Admin::findOrFail($id);
        try {
            $data->delete();

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}