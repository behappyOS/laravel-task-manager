<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Tarefa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Voltar</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
