<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sidebar With Bootstrap</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">


    <link rel="stylesheet" href="{{asset('assets/css/teacher/style.css')}}" />
    {{-- <link rel="stylesheet" href="" /> --}}
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
              <a href="#">EduVortex</a>
            </div>
          </div>
        </div>
        <ul class="sidebar-nav">
          @if(auth()->user()->is_verified == 1)
          <li class="sidebar-item">
            <a href="{{route('teacher.home')}}" class="sidebar-link">
              <i class="bi bi-house-door-fill"></i>
              <span>Dahsboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{route('profile')}}" class="sidebar-link">
              <i class="bi bi-gear"></i>
              <span>Setting</span>
            </a>
          </li>
          @endif
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
    @yield('script')
  </body>
</html>