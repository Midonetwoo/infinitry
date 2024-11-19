<?php

namespace App\Http\Controllers\Api;

//import model Project
use App\Models\Project;

use App\Http\Controllers\Controller;

//import resource ProjectResource
use App\Http\Resources\ProjectResource;

//import Http request
use Illuminate\Http\Request;

//import facade Validator
use Illuminate\Support\Facades\Validator;

//import facade storage
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all projects
        $projects = Project::latest()->paginate(5);

        //return colection of projects as a resource
        return new ProjectResource(true, 'List Data Projects', $projects);
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'thumbnail'     => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'title'         => 'required',
            'description'   => 'required',
            'type'          => 'required',
            'link'          => 'required',
            'author'        => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $thumbnail = $request->file('thumbnail');
        $thumbnail->storeAs('public/projects', $thumbnail->hashName());

        //create project
        $project = Project::create([
            'thumbnail'     => $thumbnail->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'type'          => $request->type,
            'link'          => $request->link,
            'author'        => $request->author,
        ]);

        //return response
        return new ProjectResource(true, 'Data Projects Berhasil Ditambahkan', $project);
    }

    /**
     * show
     * 
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find project by ID
        $project = Project::find($id);

        //return single post as a resource
        return new ProjectResource(true, 'Detail Data Project!', $project);
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'type'          => 'required',
            'link'          => 'required',
            'author'        => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find projects by ID
        $project = Project::find($id);

        //check if image is not empty
        if ($request->hasFile('thumbnail')) {
            //uploda image
            $thumbnail = $request->file('thumbnail');
            $thumbnail->storeAs('public/projects', $thumbnail->hashName());

            //delete old image
            Storage::delete('public/projects/' . basename($project->thumbnail));

            //update project with new image
            $project->update([
                'thumbnail'     => $thumbnail->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'type'          => $request->type,
                'link'          => $request->link,
                'author'        => $request->author,
            ]);
        } else {
            //update without image
            $project->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'type'          => $request->type,
                'link'          => $request->link,
                'author'        => $request->author,
            ]);
        }

        //return response
        return new ProjectResource(true, 'Data Project Berhasil Diubah!', $project);
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find project by ID
        $project = Project::find($id);

        //delete image
        Storage::delete('public/projects/'. basename($project->thumbnail));

        //delete project
        $project->delete();

        //return response
        return new ProjectResource(true, 'Data Project Berhasil Dihapus!', null);
    }
}
