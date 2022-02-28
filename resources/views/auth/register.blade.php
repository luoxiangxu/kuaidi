<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>TheSaaS - Register</title>

    <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/thesaas.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
  </head>

  <body class="mh-fullscreen bg-img center-vh p-20" style="background-image: url(assets/img/bg-girl.jpg);">




    <div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
      <h5 class="text-uppercase text-center">Register</h5>
      <br><br>

      <form class="form-type-material" action="/register" method="post">
          {{ csrf_field() }}
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}">
          {{$errors->first('name')}}
        </div>

        <div class="form-group">
          <input type="email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}">
          {{$errors->first('email')}}
        </div>

        <div class="form-group">
          <input type="phone" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}">
          {{$errors->first('phone')}}
        </div>

        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
          {{$errors->first('password')}}
        </div>

        <div class="form-group">
          <select class="form-control" name="user_city" value="{{ old('user_city') }}">
            <option value="" disable selected>Select your city</option>
            <option value="Nam Kham">Nam Kham</option>
            <option value="Muse">Muse</option>
            <option value="Lashio">Lashio</option>
            <option value="Pyin Oo Lwin">Pyin Oo Lwin</option>
            <option value="Mandalay">Mandalay</option>
            <option value="Yangon">Yangon</option>
          </select>
          {{$errors->first('user_city')}}
        </div>

        <br>
        <button class="btn btn-bold btn-block btn-primary" type="submit">Register</button>
      </form>

      <hr class="w-30">

      <p class="text-center text-muted fs-13 mt-20">Already have an account? <a href="/">Sign in</a></p>
    </div>


  </body>
</html>
