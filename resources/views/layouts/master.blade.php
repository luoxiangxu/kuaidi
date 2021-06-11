<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Xiao Kuai Di Yuan</title>

    <!-- Styles -->
    <link href="{{asset('assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/thesaas.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
  </head>

  <body >
    <div id="app">


    <!-- Topbar -->
    <nav class="topbar topbar-inverse topbar-expand-md topbar-sticky">
      <div class="container">
        
        <div class="topbar-left">
          <button class="topbar-toggler">&#9776;</button>
          <a class="topbar-brand" href="#">
            <h4 class="logo-default text-black" >Express Man</h4>
            <h4 class="logo-inverse text-white" >Express Man</h4>
          </a>
        </div>


        <div class="topbar-right">
          <ul class="topbar-nav nav">
            @if(auth()->check() && auth()->user()->email_verified_at!=null)
                @if(auth()->user()->isAdmin())
                  <li class="nav-item"><a class="nav-link" href="/user/profile">{{Auth::user()->name}} (ID : {{Auth::user()->id}})</a></li>
                  <li class="nav-item"><a class="nav-link" href="/admin/userpage">User Page</a></li>
                  <li class="nav-item"><a class="nav-link" href="/admin/orderrecord">Order Record</a></li>
                  <li class="nav-item"><a class="nav-link" href="/admin/order">Order</a></li>
                  <li class="nav-item"><a class="nav-link" href="/admin/arrivedorder">Arrived Order</a></li>
                  <li class="nav-item"><a class="nav-link" href="/admin/topup">Topup</a></li>
                  <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                @else
                  <li class="nav-item"><a class="nav-link" href="/user/profile"><i class="fa fa-user mr-1" style="font-size:16px; color:red;"></i>{{Auth::user()->name}} (ID : {{Auth::user()->id}})</a></li>
                  <li class="nav-item"><a class="nav-link" href="/user/shopping"><i class="fa fa-cart-plus mr-1" style="font-size:16px; color:red;"></i>Shopping</a></li>
                  <li class="nav-item"><a class="nav-link" href="/user/order"><i class="fa fa-list-alt mr-1" style="font-size:16px; color:red;"></i>Order List</a></li>
                  <li class="nav-item"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#creditModal"><i class="fa fa-credit-card mr-1" style="font-size:16px; color:red;"></i>My Wallet</a></li>
                  <li class="nav-item"><a class="nav-link" href="/user/topuprecord"><i class="fa fa-credit-card mr-1" style="font-size:16px; color:red;"></i>Topup Record</a></li>
                  <li class="nav-item"><a class="nav-link" href="/logout"><i class="fa fa-sign-out mr-1" style="font-size:16px; color:red;"></i>Logout</a></li>
                @endif
            @else
              <li class="nav-item"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in mr-1" style="font-size:16px; color:red;"></i>Login</a></li>
            @endif
          </ul>
        </div>

      </div>
    </nav>
    <!-- END Topbar -->

    @yield('header')

    



    <!-- Main container -->
    <main class="main-content">




      <!--
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      | More Header
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      !-->

      @yield('content')
      
      <div id="new">
        @yield('new')
      </div>

      <div id="bestseller">
        @yield('bestseller')
      </div>
    




    </main>
    <!-- END Main container -->



  @if(auth()->check())
    @if(auth()->user()->isAdmin())
      
    @else
      <vue-usercredit></vue-usercredit>
    @endif
  @else
    <vue-login></vue-login>
  @endif
  

    <!-- Footer -->
    <footer class="site-footer">
      <div class="container">
        <div class="row gap-y align-items-center">
          <div class="col-12 col-lg-3">
            <p class="text-center text-lg-left">
              <h4 class="text-black">Express Man</h4>
            </p>
          </div>

          <div class="col-12 col-lg-6">
            <ul class="nav nav-primary nav-hero">
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="blog.html">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="block-feature.html">Features</a>
              </li>
              <li class="nav-item hidden-sm-down">
                <a class="nav-link" href="page-pricing.html">Pricing</a>
              </li>
              <li class="nav-item hidden-sm-down">
                <a class="nav-link" href="page-contact.html">Contact</a>
              </li>
            </ul>
          </div>

          <div class="col-12 col-lg-3">
            <div class="social text-center text-lg-right">
              <a class="social-facebook" href="https://www.facebook.com/thethemeio"><i class="fa fa-facebook"></i></a>
              <a class="social-twitter" href="https://twitter.com/thethemeio"><i class="fa fa-twitter"></i></a>
              <a class="social-instagram" href="https://www.instagram.com/thethemeio/"><i class="fa fa-instagram"></i></a>
              <a class="social-dribbble" href="https://dribbble.com/thethemeio"><i class="fa fa-dribbble"></i></a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->

    </div>


    <!-- Scripts -->
    <script src="{{ asset('assets/js/core.min.js') }}"></script>
    <script src="{{ asset('assets/js/thesaas.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

  </body>
</html>
