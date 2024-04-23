<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Student\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?: $this->limit;

        $query = Student::query();

        $stream_id = $request->input('stream_id')?:null;
        if($stream_id)
            $query->where('stream_id', $stream_id);

        $division_id = $request->input('division_id')?:null;
        if($division_id)
            $query->where('division_id', $division_id);

        $q = $request->query('q')?:null;
        if($q){
            $query->where(function ($query) use ($q){
                return $query->where('name', 'like', '%'.$q.'%')
                    ->orWhere('email', 'like', '%'.$q.'%')
                    ->orWhere('mobile', 'like', '%'.$q.'%')
                    ->orWhere('spdid', 'like', '%'.$q.'%')
                    ->orWhere('enrollment_no', 'like', '%'.$q.'%');
            });
        }

        $sortBy  = $request->input('sort_by') ? : $this->sort['sort_by'];
        $sortDir  = $request->input('sort_direction') ? : $this->sort['sort_direction'];
        $query->orderBy($sortBy, $sortDir);

        $students = $query->paginate($limit);

        return StudentResource::collection($students);
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
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
