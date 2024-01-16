<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsCantroller extends Controller
{
    // This method will show jobs
    public function index(Request $request) {
        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = Job::where('status',1);

        // search using keyword

        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }

        //  search using location

        if (!empty($request->location)) {
            $jobs = $jobs->where('location',$request->location);
        }

        //  search using category

        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id',$request->category);
        }

        //  search using jobType
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',',$request->jobType);
            $jobs = $jobs->whereIn('job_type_id',$jobTypeArray);
        }

        //  search using Experience

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience',$request->experience);
        }

        $jobs = $jobs->with(['jobType','category']);

        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at','ASC');
        } else {
            $jobs = $jobs->orderBy('created_at','DESC');
        }        

        $jobs = $jobs->paginate(9);

        return view('front.jobs',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }

    // This method show job detail page

    public function detail($id) {

        $job = Job::where([
            'id' => $id, 
            'status' => 1
            ])->with(['jobType','category'])->first();
        
        if($job == null) {
            abort(404);
        }
        return view('front.jobDetail',[
            'job' => $job,
        ]);
    }

    public function applyJob(Request $request) {
        $id = $request->id;

        $job = Job::where('id',$id)->first();
        //if job not found in db
        if($job == null) {
            session()->flash('error','Job Does not exist');
            return response()->json([
                'status' => false,
                'message' => 'Job Does not exist'
            ]);
        }   
        
        // you can not apply on your own job

        $employer_id = $job->user_id;

        if($employer_id == Auth::user()->id) {
            session()->flash('error','You can not apply on your own job');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your own job'
            ]);
        }
        // You can not apply on a job twise

        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id,            
        ])->count();

        if($jobApplicationCount > 0) {
            $message = 'You have already apply on this job';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        $message = 'You have successfully applied.';
        session()->flash('success',$message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
