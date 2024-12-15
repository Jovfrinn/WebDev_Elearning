<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 200px;
  background-color: #ffffff;
  padding-top: 20px;
  border: 1px solid #064469;
  color: #064469;
}

.sidebar a {
  display: block;
  color: #333;
  padding: 16px;
  text-decoration: none;
}

.sidebar a:hover {
  background-color: #ddd;
}

.active {
  background-color: #ddd
}

.content {
  margin-left: 200px;
  padding: 20px;
}

.edit-profile{
    background-color: #DEF3FE;
}

 .profile{
    font-size: 48px;
    font-weight: 700;
    line-height: 52.22px;
    text-align: left;
    width: auto;
    border-bottom: black solid 2px;
    margin: 40px 50px;
    padding-bottom: 20px;
}

.edit-profile .data-profile{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 40px 50px;
}

.card-profile{
    background-color: rgb(255, 255, 255);
    width: auto;
    max-width: 854px;
    border-radius: 10px;
    margin: 40px 50px;
    border: 1px solid black;
}

.full-name{
    padding: 10px;
}

.your-full-name input{
    width: 100%;
}
.your-full-name{
    display: flex;
    padding: 10px;
    border-bottom:1px solid black;
    /* background-color: #red; */

}

.email{
    padding: 10px;
}

.your-email input{
    width: 100%;
}
.your-email{
    display: flex;
    padding: 10px;
    border-bottom:1px solid black;
}

.password{
    padding: 10px;
}

.your-password{  
    display: flex; 
    padding: 10px;
    border-bottom:1px solid black;

}

.button-edit{
    display: inline-block;
    color: red !important;
}
.btn-edit{
    display: flex;
    justify-content: end;
    margin: 10px 0;
}

.card-profile input{
    outline: none;
    border: none;
}

.edit-image{
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    border-bottom: 1px solid black;
}

#fileInput {
        display: none; /* Sembunyikan input asli */
    }
    #customLabel {
        display: inline-block;
        padding: 10px 20px;
        background-color: #064469;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }
    #customLabel:hover {
        background-color: #0056b3;
    }

.edit-image .image-profile img{
    width: 100px;
    height: 100px;
    border-radius:50% 
}
.image-profile .your-image{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center
}

@media (max-width: 767px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: static;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .sidebar a {
    float: left;
  }

  .content {
    margin-left: 0;
  }
}
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="{{route('get.index')}}">Home</a>
        <a href="{{route('profile')}}" class="{{ Route::currentRouteName() == 'profile' ? 'active' : '' }}">Edit Profile</a>
        <a href="#">Ganti Kata Sandi</a>
        <a href="#">Logout</a>
      </div>
      <div class="content">
        @yield('content')
            </div>
      </div>
 
      <script>
        window.addEventListener('scroll', function() {
  var sidebar = document.querySelector('.sidebar');
  var content = document.querySelector('.content');
  var scrollPosition = window.pageYOffset;

  if (scrollPosition > content.offsetTop) {
    sidebar.style.top = '0';
  } else {
    sidebar.style.top = '';
  }
});
</body>
</html>