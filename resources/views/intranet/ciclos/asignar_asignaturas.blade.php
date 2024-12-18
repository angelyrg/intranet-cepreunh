@extends('intranet.layouts.app')

@section('content')

{{-- TODO: Estandarizar los breadcrumbs --}}
{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Asignaturas del ciclo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.show', $ciclo->id) }}">{{ $ciclo->descripcion }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Asignaturas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}

{{-- content|start --}}

<div class="row">
    
    @livewire('ciclo.asignar-asignaturas-a-ciclo', ['cicloId' => $ciclo->id])

</div>


{{-- content|end --}}

@endsection

