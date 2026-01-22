<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\Technology;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        $projects = Project::with(['team', 'partner'])->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $teams = Team::all();
        $technologies = Technology::all();
        $partners = Partner::all();
        return view('projects.create', compact('teams', 'technologies', 'partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'publication_year' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:teams,id',
            'partner_id' => 'nullable|exists:partners,id',
            'technologies' => 'array',
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $project = Project::create($validated);

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        return redirect()->route('projects.index')->with('success', 'Proyecto creado.');
    }

    public function edit(Project $project)
    {
        $teams = Team::all();
        $technologies = Technology::all();
        $partners = Partner::all();
        return view('projects.edit', compact('project', 'teams', 'technologies', 'partners'));
    }

    public function update(Request $request, Project $project)
{
    Gate::authorize('update', $project);

    $validated = $request->validate([
        'title'            => 'required|string|max:255',
        'publication_year' => 'required|integer',
        'price'            => 'required|numeric|min:0',
        'stock'            => 'required|integer|min:0',
        'description'      => 'nullable|string',
        'team_id'          => 'required|exists:teams,id',
        'partner_id'       => 'nullable|exists:partners,id',
        'technologies'     => 'nullable|array',              
        'technologies.*'   => 'exists:technologies,id',      
    ]);

    $validated['is_visible'] = $request->has('is_visible');

    $project->update($validated);

    $project->technologies()->sync($request->input('technologies', []));

    return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
}

    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Eliminado.');
    }
}