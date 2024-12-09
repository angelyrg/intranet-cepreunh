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
          <li class="sidebar-item">
            <a href="{{ route('permisos.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Permisos</span>
            </a>
          </li>
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
      {{-- <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-menu-3"></i>
          </span>
          <span class="hide-menu">Menús</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('roles.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-user-shield"></i>
          </span>
          <span class="hide-menu">Roles</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('permisos.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-shield-pause"></i>
          </span>
          <span class="hide-menu">Permisos</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('usuarios.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-password-user"></i>
          </span>
          <span class="hide-menu">Usuarios</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('empleados.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-user-square-rounded"></i>
          </span>
          <span class="hide-menu">Empleados</span>
        </a>
      </li> --}}
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">ADMINISTRACIÓN</span>
      </li>

      

      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('sedes.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-building-community"></i>
          </span>
          <span class="hide-menu">Sedes</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('areas.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-hexagon-number-1"></i>
          </span>
          <span class="hide-menu">Áreas</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('carreras.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-network"></i>
          </span>
          <span class="hide-menu">Carreras</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('docentes.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-user-screen"></i>
          </span>
          <span class="hide-menu">Docentes</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('estudiantes.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-user-screen"></i>
          </span>
          <span class="hide-menu">Estudiantes</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('asignaturas.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-books"></i>
          </span>
          <span class="hide-menu">Asignaturas</span>
        </a>
      </li>
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">GESTIÓN CURRICULAR</span>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('ciclos.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-book-2"></i>
          </span>
          <span class="hide-menu">Ciclos académicos</span>
        </a>
      </li>
      {{-- <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('carreras.index') }}" aria-expanded="false">
          <span>
            <i class="ti ti-books"></i>
          </span>
          <span class="hide-menu" title="Asignación de carreras">Asig. carreras</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="  " aria-expanded="false">
          <span>
            <i class="ti ti-books"></i>
          </span>
          <span class="hide-menu" title="Asignación de asignaturas">Asig. asignaturas</span>
        </a>
      </li> --}}
      {{-- <li class="sidebar-item">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false" >
          <span class="d-flex">
            <i class="ti ti-layout"></i>
          </span>
          <span class="hide-menu">Asignaciones</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
          <li class="sidebar-item">
            <a href="{{ route('carreraciclo.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center" >
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Asig. de carreras</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('asignaturaciclo.index') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center" >
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Asig. de Asignaturas</span>
            </a>
          </li>
        </ul>
      </li> --}}
      <!-- ---------------------------------- -->
      <!-- Home -->
      <!-- ---------------------------------- -->
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">OTROS</span>
      </li>
      <!-- ---------------------------------- -->
      <!-- Dashboard -->
      <!-- ---------------------------------- -->
      {{-- <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
          <span>
            <i class="ti ti-aperture"></i>
          </span>
          <span class="hide-menu">Simple link</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
          <span class="d-flex">
            <i class="ti ti-chart-donut-3"></i>
          </span>
          <span class="hide-menu">Multiple options</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Posts</span>
            </a>
          </li>
        </ul>
      </li> --}}
      
    </ul>
</nav>