<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // This method will show our home page
    // public function index() {
    //     $jobs = Job::orderBy('id','DESC')->where('status',1)->take(4)->get();
    //     $data['letestJobs'] = $jobs;
    //     return view('front.home',$data);
    // }
    
    public function index() {

        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $data['category'] = $categories;

        $jobTypes = JobType::orderBy('name','ASC')->where('status',1)->get();
        $data['jobType'] = $jobTypes;

        $jobs = Job::where(['user_id' => Auth::user()->id])->orderBy('id','ASC')->where('status',1)->paginate(6);
        $data['letestJobs'] = $jobs;

        $featuredProducts = Job::where(['user_id' => Auth::user()->id])->where('isFeatured',0)->orderBy('id','ASC')->where('status',1)->take(6)->get();
        $data['featuredProducts'] = $featuredProducts;

        return view('front.home', $data);
    }
}
