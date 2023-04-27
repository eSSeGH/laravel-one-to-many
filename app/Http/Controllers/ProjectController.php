<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trashed = $request->input('trashed');

        if($trashed) {
            $projects = Project::onlyTrashed()->get();
        } else {
            $projects = Project::all();
        }

        $num_of_trashed = Project::onlyTrashed()->count();

        return view('projects.index', compact('projects', 'num_of_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $num_of_trashed = Project::onlyTrashed()->count();

        $types = Type::orderBy('name', 'asc')->get();

        return view('projects.create', compact('num_of_trashed', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug( $data['title'] );

        $project = Project::create($data);

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $num_of_trashed = Project::onlyTrashed()->count();

        return view('projects.show', compact('project', 'num_of_trashed'));
    }

     /**
     * Restore the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function restore(Project $project)
    {

        if ($project->trashed()) {
            $project->restore();
        }

        // uesta funzione helpers 'back()' ci rimanda indietro alla pagina nella uale abbiamo invocato il restore
        // in uesto caso è utile perchè abbiamo un pulsante restore sia nella pagina index che nella pagina 
        // show, e uindi non importa dove lo clicchiamo: ritorneremo alla pagina dove lo abbiamo cliccato
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $num_of_trashed = Project::onlyTrashed()->count();

        $types = Type::orderBy('name', 'asc')->get();

        return view('projects.edit', compact('project', 'num_of_trashed', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug( $data['title'] );

        $project->update();

        return to_route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project->trashed()) {
            $project->forceDelete();
            // eliminazione definitiva
        } else {
            $project->delete(); 
            // eliminazione soft
        }

        return back();
    }
}
