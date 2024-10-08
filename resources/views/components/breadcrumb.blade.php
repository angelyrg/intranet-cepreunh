{{-- resources/views/components/breadcrumb.blade.php --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ $parentUrl }}">{{ $parentLabel }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $currentLabel }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <button wire:click="{{ $action }}" class="btn btn-primary">
                            <i class="ti ti-books fs-4"></i> {{ $buttonLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

