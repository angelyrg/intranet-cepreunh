@extends('intranet.layouts.app')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Crear nueva área</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="#">Administración</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Áreas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('areas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-4 form-group">
                        <label>Nombre del área</label>
                        <input type="text" name="nombre_area" class="form-control @error('nombre_area') is-invalid @enderror" value="{{ old('nombre_area') }}" autofocus>
                        @error('nombre_area')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('areas.index') }}" class="btn btn-light px-4 mt-3">
                    Volver
                </a>
                <button class="btn btn-primary px-4 mt-3" type="submit">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
{{-- Notificacion tipo toast --}}
<script src="{{ asset('modernize/js/plugins/toastr-init.js') }}"></script>

<script>
    $(document).ready(function() {
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Éxito", {progressBar: true,});
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", "Error", {progressBar: true,});
        @endif
    });
</script>
@endsection