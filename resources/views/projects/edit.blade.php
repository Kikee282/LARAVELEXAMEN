@extends('layouts.app')

@section('title', 'Editar Projecte')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('projects.index') }}" class="text-sm text-slate-500 hover:text-slate-800">← Tornar</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-800">Editar: {{ $project->title }}</h1>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-900">Títol</label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                @error('title') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-900">Equip</label>
                    <select name="team_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id', $project->team_id) == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-900">Partner</label>
                    <select name="partner_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        <option value="">Cap</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}" {{ old('partner_id', $project->partner_id) == $partner->id ? 'selected' : '' }}>
                                {{ $partner->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-900">Any</label>
                    <input type="number" name="publication_year" value="{{ old('publication_year', $project->publication_year) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-900">Preu</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $project->price) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-900">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $project->stock) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-900">Tecnologies</label>
                <select name="technologies[]" multiple class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm h-32">
                    @foreach($technologies as $tech)
                        <option value="{{ $tech->id }}" 
                            {{ (collect(old('technologies'))->contains($tech->id)) || $project->technologies->contains($tech->id) ? 'selected' : '' }}>
                            {{ $tech->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" value="1" id="is_visible" {{ old('is_visible', $project->is_visible) ? 'checked' : '' }} class="rounded border-slate-300">
                <label for="is_visible" class="text-sm font-medium text-slate-700">Visible</label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="rounded-full bg-slate-900 px-8 py-2.5 text-sm font-bold text-white hover:bg-slate-800 transition">
                    Actualitzar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection