<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of teacher
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Student::all();

        return $this->successResponse($teachers);
    }

    /**
     * Create one new student
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'institute_id' => 'required|min:1',
            'full_name' => 'required|max:255',
            'department_id' => 'required|min:1',
            'phone_number' => 'required|min:11|max:11',
        ];

        $this->validate($request, $rules);

        $teacher = Student::create($request->all());

        return $this->successResponse($teacher, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one student
     * @return Illuminate\Http\Response
     */
    public function show($student)
    {
        $student = Student::findOrFail($student);

        return $this->successResponse($student);
    }

    /**
     * Update an existing student
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $student)
    {
        
        $rules = [
            'institute_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $student = Student::findOrFail($student);
        

        $student->fill($request->all());

        if ($student->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $student->save();

        return $this->successResponse($student);
    }

    /**
     * Remove an existing student
     * @return Illuminate\Http\Response
     */
    public function destroy($student)
    {
        $student = Student::findOrFail($student);

        $student->delete();

        return $this->successResponse($student);
    }
}
