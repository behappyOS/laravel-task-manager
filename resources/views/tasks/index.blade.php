<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">Nova Tarefa</a>

                    <a href="{{ route('tasks.export.csv') }}" class="btn btn-outline-secondary">Exportar CSV</a>
                    <a href="{{ route('tasks.export.pdf') }}" class="btn btn-outline-danger">Exportar PDF</a>

                    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <label for="completed" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="completed" id="completed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Todos --</option>
                                <option value="1" {{ request('completed') === '1' ? 'selected' : '' }}>Concluída</option>
                                <option value="0" {{ request('completed') === '0' ? 'selected' : '' }}>Pendente</option>
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Data Inicial</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Data Final</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Filtrar
                            </button>
                        </div>
                    </form>

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
            </div>
        </div>
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
</x-app-layout>
