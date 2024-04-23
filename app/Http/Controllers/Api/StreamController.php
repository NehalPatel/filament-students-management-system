<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stream\StreamResource;
use App\Models\Stream;
use Illuminate\Http\Request;

class StreamController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?: $this->limit;

        $query = Stream::query();

        $q = $request->query('q')?:null;
        if($q){
            $query->where(function ($query) use ($q){
                return $query->where('name', 'like', '%'.$q.'%')
                    ->orWhere('short_name', 'like', '%'.$q.'%');
            });
        }

        $sortBy  = $request->input('sort_by') ? : $this->sort['sort_by'];
        $sortDir  = $request->input('sort_direction') ? : $this->sort['sort_direction'];
        $query->orderBy($sortBy, $sortDir);

        $streams = $query->paginate($limit);
        return StreamResource::collection($streams);
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
    public function show(string $id)
    {
        //
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
