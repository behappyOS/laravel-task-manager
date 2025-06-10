<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-wrap gap-3 mb-6">
                    <a href="{{ route('tasks.create') }}" class="inline-block bg-indigo-600 text-gray-700 px-4 py-2 rounded-md hover:bg-indigo-700 shadow">
                        Nova Tarefa
                    </a>
                    <a href="{{ route('tasks.export.csv') }}" class="inline-block border border-indigo-600 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-50 shadow">
                        Exportar CSV
                    </a>
                    <a href="{{ route('tasks.export.pdf') }}" class="inline-block border border-red-600 text-red-600 px-4 py-2 rounded-md hover:bg-red-50 shadow">
                        Exportar PDF
                    </a>
                </div>

                <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">
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

                    <div class="items-end space-x-2">
                        <button type="submit" class="inline-block justify-center py-2 px-4 border shadow-sm text-sm font-medium rounded-md text-gray-700 bg-indigo-600 hover:bg-indigo-700">
                            Filtrar
                        </button>
                        <button type="button" onclick="limparFiltros()"
                                class="inline-block justify-center py-2 px-4 border shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-300 hover:bg-gray-400">
                            Limpar Pesquisa
                        </button>
                    </div>
                </form>

                @if (session('success'))
                    <div class="mb-6 rounded bg-green-100 text-green-800 p-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div x-data="{ open: false, taskId: null }" class="w-full overflow-x-auto">
                    <table class="min-w-full table-auto divide-y divide-gray-200 shadow-sm rounded-md overflow-hidden">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descrição</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Concluída</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @foreach ($tasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-normal break-words max-w-xs">{{ $task->title }}</td>
                                <td class="px-4 py-3 whitespace-normal break-words max-w-md">{{ $task->description }}</td>
                                <td class="px-4 py-3 text-center">
                                    <select class="status-dropdown rounded border border-gray-300 pr-6 py-1 text-sm w-24" data-id="{{ $task->id }}">
                                        <option value="0" {{ !$task->completed ? 'selected' : '' }}>Não</option>
                                        <option value="1" {{ $task->completed ? 'selected' : '' }}>Sim</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-700 px-3 py-1 rounded shadow text-xs">
                                        Editar
                                    </a>
                                    <button @click="$dispatch('open-modal', { id: {{ $task->id }} })"
                                            class="inline-block bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-xs">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-center">
                        {{ $tasks->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ open: false, taskId: null }" @open-modal.window="open = true; taskId = $event.detail.id">
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

            <!-- Modal box -->
            <div class="bg-white rounded-lg shadow-lg max-w-md mx-4 p-6"
                 @click.away="open = false">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Excluir Tarefa</h2>
                <p class="text-gray-700 mb-6">Tem certeza de que deseja excluir esta tarefa?</p>

                <div class="flex justify-end gap-3">
                    <button @click="open = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancelar
                    </button>

                    <form :action="`/tasks/${taskId}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

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

        function limparFiltros() {
            document.querySelector('form').reset();
            window.location.href = "{{ route('tasks.index') }}";
        }
    </script>
</x-app-layout>
