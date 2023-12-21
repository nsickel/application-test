<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create() {

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
       if (!$project) {
            return $this->return_404();
       }
       return new ProjectResource($project);
    }


    public function update(Request $request, $id) {
        /**$request->validate([
          'name' => 'required|string|max:255',
          'description' => 'required|string|max:255',
          'user_id' => auth()->user()->id
        ]);*/
        $project = Projects::find($id);
        if (!$project) {
            return $this->return_404();
        }
        $project = $project->update($request->all());
         return new ProjectResource($project);
    }

    public function destroy($id){
        $project = Projects::find($id);
        if (!$project) {
            return $this->return_404();
        }
        $project->delete();
        return response()->json([
            'message' => 'project deleted'
        ], 200);
    }

    private function return_404() {
        return response()->json(
            ['message' => 'project not found'],
            404
        );
    }

}
