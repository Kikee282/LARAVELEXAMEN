@extends('layouts.app')

@section('title', 'Llistat de Projectes')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Llistat de Projectes</h1>
        <a href="{{ route('projects.create') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 shadow-lg transition">
            + Nou Projecte
        </a>
    </div>

    {{-- Mensajes Flash --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase text-slate-500">
                <tr>
                    <th class="px-6 py-4">Títol</th>
                    <th class="px-6 py-4">Partner</th>
                    <th class="px-6 py-4 text-center">Estat</th>
                    <th class="px-6 py-4 text-right">Accions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($projects as $project)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $project->title }}</td>
                    <td class="px-6 py-4">{{ $project->partner->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($project->is_visible)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800">Visible</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">Ocult</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="{{ route('projects.edit', $project) }}" class="font-medium text-amber-600 hover:text-amber-800">Editar</a>
                        
                        @can('delete', $project)
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Segur que vols eliminar-ho?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="font-medium text-rose-600 hover:text-rose-800 ml-2">Eliminar</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $projects->links() }} 
    </div>
@endsection