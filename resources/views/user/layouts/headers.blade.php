<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EduVortex</title>
    <link rel="shortcut icon" href="{{asset('assets/img/eduvortex.png')}}" type="image/x-icon">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@30,400,0,0&icon_names=verified_user"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&family=Andika:ital,wght@0,400;0,700;1,400;1,700&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/css/styleVideo.css')}}" />
  </head>

  <body>
    <div class="wrapper">
      <aside id="sidebar" class="expand">
        <div class="bas">
          <div class="d-flex">
            <button class="toggle-btn" type="button">
              <i class="bi bi-list-task"></i>
            </button>
            <div class="sidebar-logo">
              <div class="img-logo me-1">
                <img src="{{asset('assets/img/vortex.png')}}" alt="">
              </div>
              <a href="{{route('get.index')}}">EduVortex</a>
            </div>
          </div>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-item {{ Route::currentRouteName() == 'get.index' ? 'activeBorder' : '' }}">
            <a href="{{route('get.index')}}" class="sidebar-link">
              <i class="bi bi-house"></i>
              <span>Home</span>
            </a>
          </li>
          <li class="sidebar-item {{ Route::currentRouteName() == 'all.materi' ? 'activeBorder' : '' }}">
            <a href="{{route('all.materi')}}" class="sidebar-link">
              <i class="bi bi-card-checklist"></i>
              <span>Semua Kelas</span>
            </a>
          </li>
          @if(auth()->check())
          <li class="sidebar-item">
            <a href="{{route('profile')}}" class="sidebar-link">
              <i class="bi bi-gear"></i>
              <span>Setting</span>
            </a>
          </li>
          @endif
          @if(auth()->check())
          @if (auth()->user()->id_role == 2)
          <li class="sidebar-item">
            <a href="{{route('teacher.home')}}" class="sidebar-link d-flex align-items-center">
              <span class="material-symbols-outlined me-1">
                dashboard
                </span>
              <span class="ms-2">Dashbord Pengajar</span>
            </a>
          </li>
          @endif
          @if (auth()->user()->id_role == 3)
          <li class="sidebar-item">
            <a href="{{route('admin')}}" class="sidebar-link d-flex align-items-center">
              <span class="material-symbols-outlined">
                dashboard
                </span>
              <span class="ms-1">Dashbord Admin</span>
            </a>
          </li>
          @endif
          @endif
          <li class="sidebar-footer">
            @if(auth()->check())
            <form id="logout-form" action="{{route('logout')}}" method="POST">
                @csrf

                <a type="submit" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </form>
              @else
              <a href="{{route('login')}}" class="sidebar-link">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
              </a>
              @endif
          </li>
        </ul>
      </aside>


      <aside class="sidebarResponsive">
        <div class="bas">
          <div class="d-flex">
            <button class="toggle-btn close" type="button">
              <i class="bi bi-x-lg"></i>
            </button>
            <div class="sidebar-logo">
              <a href="#">Vortex</a>
            </div>
          </div>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-item">
            <a href="{{route('get.index')}}" class="sidebar-link">
              <i class="bi bi-house"></i>
              <span>Home</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{route('all.materi')}}" class="sidebar-link">
              <i class="bi bi-card-checklist"></i>
              <span>Semua Kelas</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{route('profile')}}" class="sidebar-link">
              <i class="bi bi-gear"></i>
              <span>Setting</span>
            </a>
          </li>
          <li class="sidebar-footer">
            @if(auth()->check())
            <form id="logout-form" action="{{route('logout')}}" method="POST">
                @csrf

                <a type="submit" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </form>
              @endif
          </li>
        </ul>
      </aside>

      {{-- Main --}}
      <div class="main-content">
        <div class="navbar-section">
          <div class="navbar-logo ms-3">
            <div class="navbar-hamburger">
              <i class="bi bi-list"></i>
            </div>
              <div class="img-logo ms-1 me-1">
                <img src="{{asset('assets/img/vortex.png')}}" alt="">
              </div>
              <div class="title-vortex">Vortex</div>
          </div>
          <div class="navbar-profile me-3">
            <div class="img-profile">
              @if(isset(auth()->user()->image_profile))
              @if(null && auth()->user()->image_profile == null)
              <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="">
              @else
              <img src="{{asset('assets/img/'.auth()->user()->image_profile)}}" alt="">
              @endif
              @else
              <a href="{{route('login')}}" class="btn btn-gabung"> Login / Register</a>
              @endif
            </div>
          </div>
        </div>
   @yield('mainContent')
      </div>


    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    @yield('script')
  </body>
</html>







