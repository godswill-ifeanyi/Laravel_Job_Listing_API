<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return JobResource::collection(
            Job::where('business_id', $user->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $request->validated($request->all());

        $job = Job::create([
            'id' => 'FJB-'.uniqid(),
            'business_id' => Auth::user()->id,
            'title' => $request->title,
            'company' => $request->company,
            'company_logo' => $request->company_logo,
            'location' => $request->location,
            'category' => $request->category,
            'salary' => $request->salary,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'type' => $request->type,
            'work_condition' => $request->work_condition
        ]);

        return $this->success(new JobResource($job), 'Job Created Successfully.',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $user = Auth::user();
        // Use Policy Here

        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
