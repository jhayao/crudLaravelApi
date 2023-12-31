<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Api\Student;
use Illuminate\Http\Request;
use App\Traits\HttpResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StudentController extends Controller
{
    use HttpResponseFormatter;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentList = Student::all();
        if ($studentList->isEmpty()) {
            return $this->failure("No Student Found");
        }
        return $this->success("Student List", $studentList);
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
    public function store(StoreStudentRequest $request)
    {
        $request->validated();
        $student = Student::create($request->all());
        return $this->success("Student Created", $student);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $student = Student::find($request->id);
        return $this->success("Student Details", $student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request)
    {

        $request->validated();
        $student = Student::find($request->id);
        try {
            DB::beginTransaction();
            $user = User::where('email', $student->student_email)->first();
            $user->name = $request->student_name;
            $user->email = $request->student_email;
            $user->update();
            $student->update($request->all());
            if ($student) {
                DB::commit();
                return $this->success("Student Updated", $student);
            } else
                return $this->failure("Student Not Found");
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failure("Student Not Updated" . $e->getMessage());
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $student = Student::find($request->id);
        if ($student) {
            $student->delete();
            return $this->success("Student succesfully deleted", $student);
        }
        return $this->failure("Student Not Found");

    }
}
