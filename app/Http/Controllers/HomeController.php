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

        $categories = Category::where('status',1)->orderBy('name','ASC')->take(8)->get();

        $newCategories = Category::where('status',1)->orderBy('name','ASC')->get();

        $featuredJobs = Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->where('isFeatured',1)->take(6)->get();

        $letestJobs = Job::where('status',1)->with('jobType')->orderBy('created_at','DESC')->take(6)->get();

        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'letestJobs' => $letestJobs,
            'newCategories' => $newCategories,
        ]);
    }
}
