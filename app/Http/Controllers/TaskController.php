<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'due_date_asc');
        
        $query = Auth::user()->tasks()
            ->when($search, function($query, $search) {
                return $query->where('title', 'LIKE', "%{$search}%")
                           ->orWhere('description', 'LIKE', "%{$search}%")
                           ->orWhere('category', 'LIKE', "%{$search}%");
            });
            
        // Apply sorting
        switch($sort) {
            case 'due_date_desc':
                $query->orderBy('due_date', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            default: // due_date_asc
                $query->orderBy('due_date', 'asc');
        }
        
        $tasks = $query->get();

        return view('index', compact('tasks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'due_date' => 'required|date'
    ]);

    // Create task for logged-in user
    Auth::user()->tasks()->create([
        'title' => $request->title,
        'description' => $request->description,
        'long_description' => $request->long_description,
        'status' => $request->status, // default pending
        'priority' => $request->priority,
        'due_date' => $request->due_date,
        'category' => $request->category,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task created!');
}

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Ensure only owner can see the task
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // pass single task (not a collection)
        return view('show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // pass the single task to the edit view
        return view('edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
{
    if ($task->user_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'due_date' => 'required|date'
    ]);

    $task->update($request->all());

    return redirect()->route('tasks.index')->with('success', 'Task updated!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
{
    // Only allow owner to delete
    if ($task->user_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted!');
}
}
