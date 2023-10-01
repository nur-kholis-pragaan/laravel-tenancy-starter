<?php

namespace App\Http\Controllers\Tenant\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Tenant\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public $teacherModel;

    public function __construct()
    {
        $this->teacherModel = new Teacher();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->teacherModel->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        $data = $this->teacherModel->create([
            'nip' => $request->nip,
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            // 'data' => ["additional" => $request->nip],
        ]);

        return response()->json([
            'success' => true,
            // 'data' => $request->toArray(),
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
