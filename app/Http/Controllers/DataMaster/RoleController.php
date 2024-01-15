<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('data-master.level-pengguna.main');
    }

    public function form()
    {
        try {
            
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'code' => 500, 
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
