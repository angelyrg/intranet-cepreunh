{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            {{ __("You're logged in!") }}
        </div>
    </div>
</x-app-layout> --}}

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
                        <h5 class="fw-semibold mb-0 fs-5">¡Bienvenido de vuelta {{ Auth::user()->name }}!</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="border-end pe-4 border-muted border-opacity-10">
                            <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">12,340<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                            <p class="mb-0 text-dark">Estudiantes asistido</p>
                        </div>
                        <div class="ps-4">
                            <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">75%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                            <p class="mb-0 text-dark">Total de asistencia</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="welcome-bg-img mb-n7 text-end">
                            <img src="{{asset('modernize/images/backgrounds/welcome-bg.svg')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                <h4 class="fw-semibold">S/10,230</h4>
                <p class="mb-2 fs-3">Pendiente de matriculas</p>
                <div id="expense"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                <h4 class="fw-semibold">S/65,432</h4>
                <p class="mb-1 fs-3">Monto de matriculas</p>
                <div id="sales" class="sales-chart"></div>
                </div>
            </div>
        </div>
        
        
        
    </div>
@endsection