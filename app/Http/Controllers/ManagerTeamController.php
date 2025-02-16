<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Team;

class ManagerTeamController extends Controller
{
    // Display a list of teams
    public function index()
    {
        $teams = Team::with('agents')->where('creator_id', auth()->id())->get();


        return view('manager.team.list', compact('teams'));
    }

    // Show the form for creating a new team
    public function create()
    {
        return view('manager.team.create');
    }

    // Store a newly created team in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Team::create([
            'name' => $request->name,
            'creator_id' => auth()->id(),  // Corrected to use 'creator_id'
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created successfully!');
    }

    // Show the form for editing the specified team
    public function edit(Team $team)
    {
        return view('manager.team.edit', compact('team'));
    }

    // Update the specified team in storage
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update([
            'name' => $request->name,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team updated successfully!');
    }

    // Remove the specified team from storage
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }

    // Show the form for assigning agents to a team
    public function showAssignForm(Team $team)
    {
        $agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'Agent');
        })->get();
        
        $team->load('agents'); // Eager load agents for the team
        
        return view('manager.team.assign-agents', compact('team', 'agents'));
    }

    // Assign agents to a team
    public function assignAgents(Request $request, Team $team)
    {
        $request->validate([
            'agents' => 'required|array',
            'agents.*' => 'exists:users,id',
        ]);

        $agentsToAssign = $request->agents;

        DB::transaction(function () use ($team, $agentsToAssign) {
            // Detach agents from the team only if they are currently assigned to it
            $team->agents()->detach();
            // Assign the selected agents to the team
            $team->agents()->sync($agentsToAssign);
        });

        toastr()->closeButton(true)->success('Agents assigned successfully!');
        return redirect()->route('teams.index');
    }
    // public function showManagerLeads()
    // {
    //     // Retrieve leads created by the authenticated manager
    //     $leads = Lead::with(['assignedAgent', 'leadStatus', 'managerTeams']) // Load necessary relationships
    //         ->where('user_id', auth()->id()) // Only leads created by the logged-in user
    //         ->get();

    //     return view('manager.team.list', compact('leads'));
    // }
}
