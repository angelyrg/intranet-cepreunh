<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  


  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{asset('modernize/images/logos/favicon-unh.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{asset('modernize/css/styles.css')}}" />
  <link rel="stylesheet" href="{{asset('modernize/libs/sweetalert2/dist/sweetalert2.min.css')}}">

   <!-- Custom -->
   <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />

   {{-- Tabler io Icons Adicionales --}}
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

  @yield('css')
  @livewireStyles

  <title>Intranet - CEPRE UNH</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{asset('modernize/images/logos/favicon-unh.png')}}" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical" >
      <div>
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar 11 -->
        <!-- ---------------------------------- -->
        <div class="brand-logo bg-primary text-center d-flex align-items-center justify-content-between">
          <a href="#" class="text-nowrap logo-img">

            {{-- <img src="{{asset('modernize/images/logos/dark-logo.svg')}}" class="dark-logo" alt="Logo-Dark" />
            <img src="{{asset('modernize/images/logos/light-logo.svg')}}" class="light-logo" alt="Logo-light" /> --}}

            <img src="{{asset('modernize/images/logos/dark-logo.png')}}" class="dark-logo w-70" alt="Logo-dark" />
            <img src="{{asset('modernize/images/logos/light-logo.png')}}" class="light-logo w-70" alt="Logo-light" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        {{-- @include('livewire.users') --}}

        @include('intranet.layouts.menu')

      </div>
    </aside>
    <!--  Sidebar End -->

    <div class="page-wrapper">
      <!--  Header Start -->
      <header class="topbar">
        <div class="with-vertical">
          <!-- ---------------------------------- -->
          <!-- Start Vertical Layout Header -->
          <!-- ---------------------------------- -->
          <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
              <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  <i class="ti ti-search"></i>
                </a>
              </li>
            </ul>

            <ul class="navbar-nav quick-links d-none d-lg-flex">

              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="#">Chat</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="#">Calendar</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="#">Email</a>
              </li>
            </ul>

            <div class="d-block d-lg-none">
              <img src="{{ asset('modernize/images/logos/dark-logo.svg') }}" width="180" alt="" />
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse"
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
                <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                  type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                  aria-controls="offcanvasWithBothOptions">
                  <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                  <!-- ------------------------------- -->
                  <!-- start notification Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ti ti-bell-ringing"></i>
                      <div class="notification bg-primary rounded-circle"></div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                      aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                        <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3">
                            <img src="{{asset('modernize/images/profile/user-1.jpg')}}" alt="user" class="rounded-circle" width="48"
                              height="48" />
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                            <span class="fs-2 d-block text-body-secondary">Congratulate him</span>
                          </div>
                        </a>
                        
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3">
                            <img src="{{asset('modernize/images/profile/user-1.jpg')}}" alt="user" class="rounded-circle" width="48"
                              height="48" />
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                            <span class="fs-2 d-block text-body-secondary">Congratulate him</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Notifications</button>
                      </div>

                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start profile Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="{{asset('modernize/images/profile/user-1.jpg')}}" class="rounded-circle" width="35" height="35"
                            alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                      aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">{{ __('Perfil de usuario') }}</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{ asset('modernize/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80"
                            alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                            <span class="mb-1 d-block">Designer</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="{{ route('profile.edit') }}" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="#" alt="" width="24" height="24" />
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">{{ __('Mi perfil') }}</h6>
                              <span class="fs-2 d-block text-body-secondary">{{ __('Configuraciones de la cuenta') }}</span>
                            </div>
                          </a>
                          {{-- <a href="#" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="#" alt="" width="24" height="24" />
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">Inbox</h6>
                              <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
                            </div>
                          </a> --}}
                          
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="btn btn-outline-primary w-100">{{ __('Cerrar Sesión') }}</button>
                          </form>
                          {{-- <a href="#" class="btn btn-outline-primary">Log Out11</a> --}}
                        </div>
                      </div>

                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end profile Dropdown -->
                  <!-- ------------------------------- -->
                </ul>
              </div>
            </div>
          </nav>
          <!-- ---------------------------------- -->
          <!-- End Vertical Layout Header -->
          <!-- ---------------------------------- -->

          <!-- ------------------------------- -->
          <!-- apps Dropdown in Small screen -->
          <!-- ------------------------------- -->
          <!--  Mobilenavbar -->
          <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
              <div class="offcanvas-header justify-content-between">
                {{-- <img src="../assets/images/logos/favicon.ico" alt="" class="img-fluid" /> --}}
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body" data-simplebar="" data-simplebar style="height: calc(100vh - 80px)">
                <ul id="sidebarnav">
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="../main/app-chat.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-message-dots"></i>
                      </span>
                      <span class="hide-menu">Chat</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="../main/app-calendar.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-calendar"></i>
                      </span>
                      <span class="hide-menu">Calendar</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link" href="../main/app-email.html" aria-expanded="false">
                      <span>
                        <i class="ti ti-mail"></i>
                      </span>
                      <span class="hide-menu">Email</span>
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>

        </div>
        <div class="app-header with-horizontal">
          <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
              <li class="nav-item d-none d-xl-block">
                <a href="#" class="text-nowrap nav-link">
                  <img src="{{ asset('modernize/images/logos/dark-logo.svg') }}" class="dark-logo" width="180" alt="" />
                  <img src="{{ asset('modernize/images/logos/light-logo.svg') }}" class="light-logo" width="180" alt="" />
                </a>
              </li>
              <li class="nav-item d-none d-xl-block">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  <i class="ti ti-search"></i>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-xl-flex">
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="../main/app-chat.html">Chat</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="../main/app-calendar.html">Calendar</a>
              </li>
              <li class="nav-item dropdown-hover d-none d-lg-block">
                <a class="nav-link" href="../main/app-email.html">Email</a>
              </li>
            </ul>
            <div class="d-block d-xl-none">
              <a href="#" class="text-nowrap nav-link">
                <img src="{{ asset('modernize/images/logos/dark-logo.svg') }}" width="180" alt="" />
              </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse"
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                <a href="javascript:void(0)"
                  class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                  type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                  aria-controls="offcanvasWithBothOptions">
                  <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <!-- ------------------------------- -->
                  <!-- start notification Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ti ti-bell-ringing"></i>
                      <div class="notification bg-primary rounded-circle"></div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                      aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7">
                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                        <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                      </div>
                      <div class="message-body" data-simplebar>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3">
                            <img src="{{ asset('modernize/images/profile/user-1.jpg') }}" alt="user" class="rounded-circle" width="48"
                              height="48" />
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                            <span class="fs-2 d-block text-body-secondary">Congratulate him</span>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <span class="me-3">
                            <img src="{{ asset('modernize/images/profile/user-1.jpg') }}" alt="user" class="rounded-circle" width="48"
                              height="48" />
                          </span>
                          <div class="w-75 d-inline-block v-middle">
                            <h6 class="mb-1 fw-semibold lh-base">New message</h6>
                            <span class="fs-2 d-block text-body-secondary">Salma sent you new message</span>
                          </div>
                        </a>
                      </div>
                      <div class="py-6 px-7 mb-1">
                        <button class="btn btn-outline-primary w-100">See All Notifications</button>
                      </div>

                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end notification Dropdown -->
                  <!-- ------------------------------- -->

                  <!-- ------------------------------- -->
                  <!-- start profile Dropdown -->
                  <!-- ------------------------------- -->
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="{{ asset('modernize/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35"
                            alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                      aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile!!!!!!!!</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{ asset('modernize/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80"
                            alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3">Mathew Anderson</h5>
                            <span class="mb-1 d-block">Designer</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> info@modernize.com
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="#" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="" alt="" width="24" height="24" />
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                              <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                            </div>
                          </a>
                          <a href="#" class="py-8 px-7 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                              <img src="" alt="" width="24" height="24" />
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 fs-3 fw-semibold lh-base">My Inbox</h6>
                              <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
                            </div>
                          </a>
                          
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <a href="#" class="btn btn-outline-primary">Log Out1</a>
                        </div>
                      </div>

                    </div>
                  </li>
                  <!-- ------------------------------- -->
                  <!-- end profile Dropdown -->
                  <!-- ------------------------------- -->
                </ul>
              </div>
            </div>
          </nav>

        </div>
      </header>
      <!--  Header End -->

      <aside class="left-sidebar with-horizontal">
        <!-- Sidebar scroll-->
        <div>
          <!-- Sidebar navigation Horizontal Mode-->
          <nav class="sidebar-nav scroll-sidebar container-fluid">
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Home -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                  <span>
                    <i class="ti ti-home-2"></i>
                  </span>
                  <span class="hide-menu">Dashboard H</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                      <i class="ti ti-aperture"></i>
                      <span class="hide-menu">Modern</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="../main/index2.html" class="sidebar-link">
                      <i class="ti ti-shopping-cart"></i>
                      <span class="hide-menu">eCommerce</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="../main/index3.html" class="sidebar-link">
                      <i class="ti ti-currency-dollar"></i>
                      <span class="hide-menu">NFT</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="../main/index4.html" class="sidebar-link">
                      <i class="ti ti-cpu"></i>
                      <span class="hide-menu">Crypto</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="../main/index5.html" class="sidebar-link">
                      <i class="ti ti-activity-heartbeat"></i>
                      <span class="hide-menu">General</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="../main/index6.html" class="sidebar-link">
                      <i class="ti ti-playlist"></i>
                      <span class="hide-menu">Music</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->

      </aside>

      <div class="body-wrapper">
        <div class="container-fluid">
            
          {{-- @yield('content') --}}
          @livewire('estudiante.estudiante-list')

        </div>
      </div>
      <script>
        function handleColorTheme(e) {
          $("html").attr("data-color-theme", e);
          $(e).prop("checked", !0);
        }
      </script>
      <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="icon ti ti-settings fs-7"></i>
      </button>

      <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            Settings
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" data-simplebar style="height: calc(100vh - 80px)">
          <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="theme-layout" id="light-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="light-layout"><i
                class="icon ti ti-brightness-up fs-7 me-2"></i>Light</label>

            <input type="radio" class="btn-check" name="theme-layout" id="dark-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="dark-layout"><i
                class="icon ti ti-moon fs-7 me-2"></i>Dark</label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="ltr-layout"><i
                class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR</label>

            <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="rtl-layout"><i
                class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL</label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

          <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
            <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="BLUE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="AQUA_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="PURPLE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
              autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="GREEN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="CYAN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
              autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="ORANGE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="vertical-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="vertical-layout"><i
                  class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical</label>
            </div>
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="horizontal-layout"><i
                  class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal</label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed</label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full</label>
          </div>

          <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <a href="javascript:void(0)" class="fullsidebar">
              <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="full-sidebar"><i
                  class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full</label>
            </a>
            <div>
              <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="mini-sidebar"><i
                  class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse</label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="card-layout" id="card-with-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-with-border"><i
                class="icon ti ti-border-outer fs-7 me-2"></i>Border</label>

            <input type="radio" class="btn-check" name="card-layout" id="card-without-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-without-border"><i
                class="icon ti ti-border-none fs-7 me-2"></i>Shadow</label>
          </div>
        </div>
      </div>
    </div>
   

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

  <script src="{{asset('modernize/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('modernize/js/app.min.js')}}"></script>
  <script src="{{asset('modernize/js/app.init.js')}}"></script>
  <script src="{{asset('modernize/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('modernize/libs/simplebar/dist/simplebar.min.js')}}"></script>

  <script src="{{asset('modernize/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('modernize/js/theme.js')}}"></script>

  <script src="{{ asset('modernize/js/plugins/toastr-init.js') }}"></script>
  <script src="{{ asset('modernize/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

  {{-- validate --}}
  <script src="{{ asset('modernize/js/extra-libs/jqbootstrapvalidation/validation.js') }}"></script>
  <script src="{{ asset('modernize/js/forms/custom-validation-init.js') }}"></script>

  @yield('scripts')

  @livewireScripts
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('show-alert', (event) => {
            Swal.fire({
                title: '¡Éxito!',
                text: event.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    });
  </script>

</body>

</html>