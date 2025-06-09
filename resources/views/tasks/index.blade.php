@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">Nova Tarefa</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Concluída</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        <select class="form-select form-select-sm status-dropdown" data-id="{{ $task->id }}">
                            <option value="0" {{ !$task->completed ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ $task->completed ? 'selected' : '' }}>Sim</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Confirma exclusão?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.status-dropdown').change(function () {
                const taskId = $(this).data('id');
                const completed = $(this).val();

                $.ajax({
                    url: `/tasks/${taskId}/toggle-completed`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        completed: completed
                    },
                    success: function () {
                        console.log('Atualizado com sucesso');
                    },
                    error: function () {
                        alert('Erro ao atualizar status');
                    }
                });
            });
        });
    </script>
@endsection
