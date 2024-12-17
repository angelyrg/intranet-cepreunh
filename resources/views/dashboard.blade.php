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
@endsection