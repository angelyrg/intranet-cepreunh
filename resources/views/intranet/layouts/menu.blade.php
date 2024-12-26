<nav class="sidebar-nav scroll-sidebar" data-simplebar>
    <ul id="sidebarnav">
      <li class="sidebar-item mt-2">
        <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
          <span>
            <i class="ti ti-dashboard"></i>
          </span>
          <span class="hide-menu">Dashboard</span>
        </a>
      </li>
      @can('ver configuracion del sistema')
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">CONFIG. DEL SISTEMA</span>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
          <span class="d-flex">
            <i class="ti ti-chart-donut-3"></i>
          </span>
          <span class="hide-menu">General</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
          <li class="sidebar-item">
            <a href="{{ route('roles.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Roles</span>
            </a>
          </li>
          {{-- <li class="sidebar-item">
            <a href="{{ route('permisos.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Permisos</span>
            </a>
          </li> --}}
          <li class="sidebar-item">
            <a href="{{ route('usuarios.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Usuarios</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('empleados.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Empleados</span>
            </a>
          </li>
        </ul>
      </li>
      @endcan
      
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">ADMINISTRACIÓN</span>
      </li>

      @can('sedes.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('sedes.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-building-community"></i>
          </span>
          <span class="hide-menu">Sedes</span>
        </a>
      </li>
      @endcan
      
      @can('areas.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('areas.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-hexagon-number-1"></i>
          </span>
          <span class="hide-menu">Áreas</span>
        </a>
      </li>
      @endcan

      @can('carreras.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('carreras.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-network"></i>
          </span>
          <span class="hide-menu">Carreras</span>
        </a>
      </li>
      @endcan

      @can('pagos.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-coin"></i>
          </span>
          <span class="hide-menu">Pagos</span>
        </a>
      </li>
      @endcan

      @can('aulas.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('aulas.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-door"></i>
          </span>
          <span class="hide-menu">Aulas</span>
        </a>
      </li>
      @endcan

      <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">GESTIÓN ACADÉMICA</span>
      </li>
      
      @can('ciclos.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('ciclos.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-book-2"></i>
          </span>
          <span class="hide-menu">Ciclos académicos</span>
        </a>
      </li>
      @endcan
      
      @can('docentes.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('docentes.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-user-pentagon"></i>
          </span>
          <span class="hide-menu">Docentes</span>
        </a>
      </li>
      @endcan
      
      @can('estudiantes.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('estudiante.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-users"></i>
          </span>
          <span class="hide-menu">Estudiantes</span>
        </a>
      </li>
      @endcan

      @can('asignaturas.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('asignaturas.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-books"></i>
          </span>
          <span class="hide-menu">Asignaturas</span>
        </a>
      </li>
      @endcan

      @can('asistencias.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-mood-check"></i>
          </span>
          <span class="hide-menu">Asistencias</span>
        </a>
      </li>
      @endcan

      @can('evaluaciones.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-checklist"></i>
          </span>
          <span class="hide-menu">Evaluaciones</span>
        </a>
      </li>
      @endcan

      @can('encuestas.lista')
      <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-gradienter"></i>
          </span>
          <span class="hide-menu">Encuestas</span>
        </a>
      </li>
      @endcan

      @can('cms.configuracion')
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">PÁGINA WEB</span>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
          <span class="d-flex">
            <i class="ti ti-chart-donut-3"></i>
          </span>
          <span class="hide-menu">CMS</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Contenidos (Noticias)</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Comunicados (Docs)</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Anuncios (Popups)</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Carousel (Home)</span>
            </a>
          </li>
        </ul>
      </li>
      @endcan
      
    </ul>
</nav>