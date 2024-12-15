<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sidebar With Bootstrap</title>
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
    <link rel="stylesheet" href="{{asset('/assets/css/admin/style.css')}}" />
  </head>

  <body>
    <div class="wrapper">
      <aside id="sidebar">
        <div class="bas">
          <div class="d-flex">
            <button class="toggle-btn" type="button">
              <i class="bi bi-list-task"></i>
            </button>
            <div class="sidebar-logo">
              <a href="#">Vortex</a>
            </div>
          </div>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-item {{ Route::currentRouteName() == 'admin' ? 'activeBorder' : '' }}">
            <a href="{{route('admin')}}" class="sidebar-link">
              <i class="bi bi-house"></i>
              <span>Beranda</span>
            </a>
          </li>
          <li class="sidebar-item {{ Route::currentRouteName() == 'get.student' ? 'activeBorder' : '' }}">
            <a href="{{route('get.student')}}" class="sidebar-link">
              <i class="bi bi-people-fill"></i>
              <span>Peserta</span>
            </a>
          </li>
          <li class="sidebar-item {{ Route::currentRouteName() == 'get.materi' ? 'activeBorder' : '' }}">
            <a href="{{route('get.materi')}}" class="sidebar-link">
              <i class="bi bi-journal-text"></i>
              <span>Materi</span>
            </a>
          </li>
          <li class="sidebar-item {{ Route::currentRouteName() == 'get.teachers' ? 'activeBorder' : '' }}">
            <a href="{{route('get.teachers')}}" class="sidebar-link">
              <i class="bi bi-person-workspace"></i>
              <span>Pengajar</span>
            </a>
          </li>
          <li class="sidebar-item {{ Route::currentRouteName() == 'get.teacher' ? 'activeBorder' : '' }}">
            <a href="{{route('get.teacher')}}" class="sidebar-link">
              <i class="bi bi-person-check"></i>
              <span>Pengajar Verifikasi</span>
            </a>
          </li>
          {{-- <li class="sidebar-item">
            <a
              href="#"
              class="sidebar-link collapsed has-dropdown"
              data-bs-toggle="collapse"
              data-bs-target="#auth"
              aria-expanded="false"
              aria-controls="auth"
            >
              <i class="bi bi-mortarboard-fill"></i>
              <span>Bergabung</span>
            </a>
            <ul
              id="auth"
              class="sidebar-dropdown list-unstyled collapse"
              data-bs-parent="#sidebar"
            >
              <li class="sidebar-item">
                <a href="#" class="sidebar-link"></a>
              </li>
            </ul>
          </li> --}}
          <li class="sidebar-item">
            <a href="{{route('profile')}}" class="sidebar-link">
              <i class="bi bi-gear"></i>
              <span>Setting</span>
            </a>
          </li>
        </ul>
        <div class="sidebar-footer">
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
        </div>
      </aside>

      <div class="main-content">
       @yield('teacherContent')
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
  </body>
</html>



