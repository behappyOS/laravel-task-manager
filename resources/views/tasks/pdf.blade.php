<h1>Lista de Tarefas</h1>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>Título</th>
        <th>Descrição</th>
        <th>Concluída</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->completed ? 'Sim' : 'Não' }}</td>
            <td>{{ $task->created_at->format('d/m/Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
