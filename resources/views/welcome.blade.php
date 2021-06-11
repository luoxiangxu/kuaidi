@extends('layouts.master')

@section('header')
<!-- Header -->
    <header class="header header-inverse py-200 h-fullscreen" style="background-image: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);">
      <div class="container text-center">

        <div class="row h-full">
          <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

            <h1 class="hidden-sm-down">Order From <span class="text-primary" data-type="TaoBao, TMall, 168.com"></span></h1>
            <h1 class="hidden-md-up">Order From <br><span class="text-primary" data-type="TaoBao, TMall, 168.com"></span></h1>
            <br>
            <p class="fs-20 hidden-sm-down"><span class="fw-400">Express Man</span> is a well know delivery company in Myanmar.</p>
            <p class="fs-15 hidden-md-up"><span class="fw-400">Express Man</span> is a well know delivery company in Myanmar.</p>

            <br>
            <hr class="w-50 hidden-sm-down">
            <br>

            <p>
            <a class="btn btn-lg btn-round w-200 btn-primary mr-16" data-scrollto="new">New</a>
            <a class="btn btn-lg btn-round w-200 btn-primary mr-16" data-scrollto="bestseller">Best Seller</a>
            </p>
            

          </div>
        </div>

      </div>
    </header>
<!-- END Header -->
@stop

@section('new')
<section class="section" id="section-intro">
        <div class="container">
          <header class="section-header">
            <small>New coming</small>
            <h2>New Itmes arrive recently</h2>
            <hr>
          </header>
          <div class="row gap-y">
          <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Women dress</h5>
                        <p>Superior Women dress</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>15000</div>
                    </div>
                    <img src="/images/itemimages/womendress.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Adidas</h5>
                        <p>Sport</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>50000</div>
                    </div>
                    <img src="/images/itemimages/adidas.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>High Heel</h5>
                        <p>Superior High Heel</p>
                      </div>

                      <div class="item-price"><span class="unit">kyat</span>20000</div>
                    </div>
                    <img src="/images/itemimages/highheel.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Women Bag</h5>
                        <p>Superior Women Bag</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>60000</div>
                    </div>
                    <img src="/images/itemimages/womenbag.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>IPHONE 10</h5>
                        <p>Apple</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>1200000</div>
                    </div>
                    <img src="/images/itemimages/iphone.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Sony Head Set</h5>
                        <p>Sony</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>200000</div>
                    </div>
                    <img src="/images/itemimages/sonyheadset.jpg" alt="product">
                  </a>
            </div>

          </div>

        </div>
      </section>
@stop

@section('bestseller')
<section class="section" id="section-intro">
        <div class="container">
          <header class="section-header">
            <small>Best seller</small>
            <h2>Most popular Items</h2>
            <hr>
          </header>


          <div class="row gap-y">
            
            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>IPHONE 10 Cover</h5>
                        <p>Apple</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>12000</div>
                    </div>
                    <img src="/images/itemimages/phonecover.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Bracelet</h5>
                        <p>Zhong Da Fu</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>3000000</div>
                    </div>
                    <img src="/images/itemimages/bracelet.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Snack Bag</h5>
                        <p>Spicy snack</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>6000</div>
                    </div>
                    <img src="/images/itemimages/snackbag.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Xiao Mi Laptop</h5>
                        <p>16 inches</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>800000</div>
                    </div>
                    <img src="/images/itemimages/laptop.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Air Condition</h5>
                        <p>Media</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>400000</div>
                    </div>
                    <img src="/images/itemimages/aircondition.jpg" alt="product">
                  </a>
            </div>


            <div class="col-12 col-md-6 col-xl-4">
                  <a class="shop-item" href="#">
                    <div class="item-details">
                      <div>
                        <h5>Lipstick</h5>
                        <p>CHANEL</p>
                      </div>

                      <div class="item-price"><span class="unit">Kyat</span>60000</div>
                    </div>
                    <img src="/images/itemimages/lipstick.jpg" alt="product">
                  </a>
            </div>

          </div>


        </div>
      </section>
@stop