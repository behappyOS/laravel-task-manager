<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());

        if ($request->has('completed') && $request->completed !== '') {
            $query->where('completed', $request->completed);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tasks = $query->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean'
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa removida.');
    }

    public function toggleCompleted(Request $request, Task $task)
    {
        $task->completed = $request->completed;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function exportCsv()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        $csvData = "Título,Descrição,Concluída,Data\n";

        foreach ($tasks as $task) {
            $csvData .= "\"{$task->title}\",\"{$task->description}\",\"" . ($task->completed ? 'Sim' : 'Não') . "\",\"{$task->created_at->format('d/m/Y')}\"\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tarefas.csv"',
        ]);
    }

    public function exportPdf()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        $pdf = PDF::loadView('tasks.pdf', compact('tasks'));
        return $pdf->download('tarefas.pdf');
    }

}
