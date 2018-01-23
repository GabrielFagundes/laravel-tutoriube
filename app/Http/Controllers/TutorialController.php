<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use App\Tutorial;
use Illuminate\Http\Request;
use App\Youtube;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function show($videoId){

        $tutorial = Tutorial::where('link', $videoId)->first();
//        dd($tutorial->link);
//
        return view('tutorial.post')->with(compact('tutorial'));
    }

    public function uploadIndex(){
        $youtube = new Youtube;
        $uploadedVideos = $youtube->returnUploadedVideos();
        $videoContents = $youtube->returnVideoContent($uploadedVideos);

        return view('tutorial.upload')->with(compact('uploadedVideos', 'videoContents'));
    }

    public function uploadCreate($videoid){
        $video = $videoid;
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('tutorial.completeupload')->with(compact('video', 'categories', 'subcategories'));
    }

    public function uploadSubmit(Request $request){

        //echo 'teste'; exit;
//
//        $validatedData = $request->validate([
//            'titulo'        => 'required|max:20',
//            'description'   => 'required|max:1000',
//        ]);

        $tutorial = Tutorial::where('link', $request->video)->first();

        if (!$tutorial){
            $tutorial = new Tutorial;
            $tutorial->title = $request->title;
            $tutorial->description = $request->description;
            $tutorial->link = $request->video;
            $tutorial->category_id = $request->category;
            $tutorial->subcategory_id = $request->subcategory;
            $tutorial->user_id = Auth::user()->id;

            $tutorial->save();
        }
        else {
            echo 'erro';
            exit;
            $erro = true;
        }

        return redirect('home');
    }

}