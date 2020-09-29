<?php

namespace App\Http\Controllers;

use App\Course;
use App\Section;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use App\Http\Managers\VideoManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    public function __construct(VideoManager $videoManager) {
        $this->videoManager = $videoManager;
    }

    public function index($id){

        $course = Course::find($id);
        return view('instructor.curriculum.index',[
            'course' => $course
        ]);
    }

    public function create($id){

        $course = Course::find($id);
        return view('instructor.curriculum.create',[
            'course' => $course
        ]);
    }

    public function store(Request $request, $id){

        $section = new Section();
        $course = Course::find($id);
        $slugify = new Slugify();


        $section->name = $request->input('section_name');
        $section->slug = $slugify->slugify($section->name);

        $video = $this->videoManager->videoStorage($request->file('section_video'));

        $section->video = $video;
        $section->course_id = $id;

        $playtime = $this->videoManager->getVideoDuration($video);
        $section->playtime_seconds = $playtime;

        $section->save();
        return redirect()->route('instructor.curriculum.index', $course->id);
    }

    public function edit($id, $sectionId) {
        $course = Course::find($id);
        $section = Section::find($sectionId);
        return view('instructor.curriculum.edit',[
            'course' => $course,
            'section' => $section
        ]);
    }

    public function update(Request $request, $id, $sectionId) {

        $slugify = new Slugify();
        $course = Course::find($id);
        $section = Section::find($sectionId);

        if($request->input('section_name')) {
            // Update nom de la section
            $section->name = $request->input('section_name');
            $section->slug = $slugify->slugify($section->name);
        }
        if($request->file('section_video')) {
            // Update video de la section
            $video = $this->videoManager->videoStorage($request->file('section_video'));
            $section->video = $video;
            $section->playtime_seconds = $this->videoManager->getVideoDuration($video);
        }

        $section->save();
        return redirect()->route('instructor.curriculum.index',$course->id)->with('success', 'La section a bien été modifiée !');
    }

    public function destroy($id, $sectionId) {
        $section = Section::find($sectionId);
        $course = Course::find($id);
        $fileToDelete = 'public/courses_sections/' . Auth::user()->id . '/' . $section->video;


        if(Storage::exists($fileToDelete)) {
            Storage::delete($fileToDelete);
        }

        $section->delete();
        return redirect()->route('instructor.curriculum.index', $course->id)->with('success', 'La section a correctement été supprimée !');
    }
}
