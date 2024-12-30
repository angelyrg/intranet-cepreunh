@extends('intranet.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100 bg-info-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="{{asset('modernize/images/profile/user-1.jpg')}}" alt="" width="40" height="40">
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-0 fs-5">¡Bienvenido de vuelta {{ Auth::user()->name }}!</h5>
                                    <p>{{ Auth::user()->roles->first()?->name }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('ciclos.index') }}" class="btn btn-outline-primary">
                                    <span>Ir a ciclos académicos</span>
                                    <i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <div class="bg-primary-subtle rounded-top-2 px-3 py-2">
                <h5 class="text-primary mb-0">Ciclos activos</h5>
            </div>
        </div>
        @foreach ($ciclos as $ciclo)   
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div>
                            <h5 class="fw-semibold mb-0">{{ $ciclo->descripcion }}</h5>
                            <span class="fs-2 d-flex align-items-center">
                                <i class="ti ti-calendar text-dark fs-3 me-1"></i>
                                <span>{{ \Carbon\Carbon::parse($ciclo->created_at)->format('d/m/Y') }}</span>
                            </span>
                        </div>
                        <a href="{{ route('ciclos.show', $ciclo->id) }}" class="btn btn-primary py-1 px-2 ms-auto">
                            Ver
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection