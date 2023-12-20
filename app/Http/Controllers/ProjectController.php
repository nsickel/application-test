<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create() {
        // Create a new project
        $project = Projects::create([
            'name' => request()->name,
            'description' => request()->description,
            'user_id' => auth()->user()->id,
        ]);

        // Return the created project
        return new ProjectResource($project);
    }

    public function read($id){
        $project = Projects::find($id);
        return new ProjectResource($project);
    }


    public function update(Request $request, $id) {
        $request->validate([
          'title' => 'required|max:255',
          'body' => 'required',
        ]);
        $project = Projects::find($id);
        $project->update($request->all());
        return new ProjectResource($project);
    }

    public function destroy($id){

        $post = Projects::find($id);
        $post->delete();
    }

}
