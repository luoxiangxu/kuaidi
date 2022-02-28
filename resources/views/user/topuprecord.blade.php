@extends('layouts.master')

@section('header')
<!-- Header -->
    <header class="header header-inverse" style="background-image: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);">
      <div class="container text-center">

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">

            <h3>{{auth()->user()->name}}'s Topup Record</h3>

          </div>
        </div>
      </div>
    </header>
    <!-- END Header -->
@stop
@section('content')
<vue-topuprecord></vue-topuprecord>
@stop