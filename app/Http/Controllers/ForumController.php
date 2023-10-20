<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
        $data = [
            'datas' => $forum->all(),
        ];
        return view('forum.index', $data);
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
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum, string $id)
    {

        $data = [
            'data' => Forum::where('id_forum', $id)->first()
        ];

        return view('forum.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum)
    {
        //
    }
}
