<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SuperAdmin $superAdmin, Request $request, string $id)
    {
        $data = [
            'data' => SuperAdmin::join('akun', 'super_admin.id_akun', '=', 'akun.id_akun')
            ->select('super_admin.*', 'akun.id_akun')
            ->where('super_admin.id_akun', '=', $id)
            ->get()
        ];

        return view('profile.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superAdmin)
    {
        //
    }
}
