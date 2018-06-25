@extends('frontlayouts.master')
@section('title', 'Best Product Ever Fro Buying')
@section('content')
    <!--Slider Area Start-->
    <div class="slider-area">
        <div class="fullwidthbanner-container">
            <div class="fullwidthbanner">
                <ul>
                    <!-- Slide One -->
                    <li class="slider" data-transition="random" data-slotamount="7" data-masterspeed="300">
                        <!-- Main Image-->
                        <img src="{{asset('front/img/slider/slider-1.jpg')}}" alt=""  data-bgposition="center top" data-bgrepeat="no-repeat" data-bgpositionend="center center">
                        <!-- Layer One -->
                        <div class="tp-caption  randomrotate start"
                             data-x="center" data-hoffset="270"
                             data-y="center" data-voffset="-108"
                             data-start="800"
                             data-speed="800"
                             data-easing="Power2.easeOut"
                             data-captionhidden="off"
                             data-endeasing="Power1.easeIn"
                             data-endspeed="1500"
                             style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;background-color: transparent; font-size: 48px; font-weight:500; color:#ef5656; text-transform: uppercase;translate3d(0px, 0px, 0px)">Biggest

                        </div>
                        <!-- Layer Two -->
                        <div class="tp-caption slider-one-text sfl tp-resizeme rs-parallaxlevel-0 home-1-rs-1"
                             data-x="center" data-hoffset="275"
                             data-y="center" data-voffset="-49"
                             data-speed="800"
                             data-start="1000"
                             data-easing="easeInOutExpo"
                             data-splitin="none"
                             data-splitout="none"
                             data-elementdelay="0.1"
                             data-endelementdelay="0.1"
                             data-endspeed="300"

                             style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;background-color: transparent; font-size: 70px; color:#fefefe; text-transform: uppercase; font-weight:700">SALE ON
                        </div>
                        <!-- Layer THree -->
                        <div class="tp-caption slider1_slide2_t3black sfr tp-resizeme rs-parallaxlevel-0 home-1-rs-5"
                             data-x="center" data-hoffset="274"
                             data-y="center" data-voffset="14"
                             data-speed="800"
                             data-start="1500"
                             data-easing="easeInOutExpo"
                             data-splitin="none"
                             data-splitout="none"
                             data-elementdelay="0.1"
                             data-endelementdelay="0.1"
                             data-endspeed="1500"
                             style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap; background-color: transparent;  font-size: 48px; font-weight: 500; color:#ef5656;">SUMMER COLLECTION
                        </div>
                        <!-- layer Four -->
                        <div class="tp-caption sfb tp-resizeme rs-parallaxlevel-0 home-1-rs-4"
                             data-x="center" data-hoffset="275"
                             data-y="center" data-voffset="98"
                             data-speed="800"
                             data-start="2000"
                             data-easing="easeInOutExpo"
                             data-splitin="none"
                             data-splitout="none"
                             data-elementdelay="0.1"
                             data-endelementdelay="0.1"
                             data-endspeed="1500"
                             style="z-index: 8; max-width: auto; max-height: auto; white-space: nowrap;"><a href='#' class='button-text'>Shop Now</a>
                        </div>
                    </li>
                    <!-- Slide Two -->
                    <li class="slider" data-transition="random" data-slotamount="9" data-masterspeed="300" data-saveperformance="off">
                        <!-- Main Image-->
                        <img src="{{asset('front/img/slider/slider-2.jpg')}}"
                             alt="kenburns1"
                             data-kenburns="on"
                             data-bgposition="center top"
                             data-bgpositionend="center center"
                             data-bgfit="100"
                             data-bgfitend="120"
                             data-duration="10000"
                             data-ease="Linear.easeNone">
                        <!-- Layer One -->
                        <div class="tp-caption  randomrotate start"
                             data-x="center" data-hoffset="-270"
                             data-y="center" data-voffset="-108"
                             data-start="800"
                             data-speed="800"
                             data-easing="Power2.easeOut"
                             data-captionhidden="off"
                             data-endeasing="Power1.easeIn"
                             data-endspeed="1500"
                             style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;background-color: transparent; font-size: 48px; font-weight:500; color:#ef5656; text-transform: uppercase;translate3d(0px, 0px, 0px)">Biggest

                        </div>
                        <!-- Layer Two -->
                        <div class="tp-caption slider-two-text customin customout tp-resizeme start"
                             data-x="center" data-hoffset="-275"
                             data-y="center" data-voffset="-49"
                             data-elementdelay="0.1"
                             data-splitout="none"
                             data-splitin="none"
                             data-easing="Power3.easeInOut"
                             data-start="1000"
                             data-speed="1300"
                             data-end="8000"
                             data-endspeed="1500"
                             data-endeasing="Power3.easeInOut"
                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:5;scaleY:5;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                             data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:5;scaleY:5;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                             style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;background-color: transparent; visibility: visible; transform: translate3d(0px, 0px, 0px) scale(5, 5); transform-origin: 50% 50% 0px; font-size: 70px; color:#313131; text-transform: uppercase; font-weight:700">SALE ON
                        </div>
                        <!-- Layer THree -->
                        <div class="tp-caption slider1_slide2_t3black sfr tp-resizeme rs-parallaxlevel-0 home-1-rs-5"
                             data-x="center" data-hoffset="-274"
                             data-y="center" data-voffset="14"
                             data-speed="800"
                             data-start="1500"
                             data-easing="easeInOutExpo"
                             data-splitin="none"
                             data-splitout="none"
                             data-elementdelay="0.1"
                             data-endelementdelay="0.1"
                             data-endspeed="1500"
                             style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap; background-color: transparent;  font-size: 48px; font-weight: 500; color:#ef5656;">SUMMER COLLECTION
                        </div>
                        <!-- layer Four -->
                        <div class="tp-caption sfb tp-resizeme rs-parallaxlevel-0 home-1-rs-4"
                             data-x="center" data-hoffset="-275"
                             data-y="center" data-voffset="98"
                             data-speed="800"
                             data-start="2000"
                             data-easing="easeInOutExpo"
                             data-splitin="none"
                             data-splitout="none"
                             data-elementdelay="0.1"
                             data-endelementdelay="0.1"
                             data-endspeed="1500"
                             style="z-index: 8; max-width: auto; max-height: auto; white-space: nowrap;"><a href='#' class='button-text'>Shop Now</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--End of Slider Area-->
    <!--Product Area Start-->
    <section class="product-area">
        <div class="product-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <div class="single-product">
                            <a href="product-details.html"><img src="{{asset('front/img/product/product-1.jpg')}}" alt="">
                                <div class="product-text">
                                    <h4>MEN'S</h4>
                                    <h5>Summer Collection</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <div class="single-product">
                            <a href="product-details.html"><img src="{{asset('front/img/product/product-2.jpg')}}" alt="">
                                <div class="product-text">
                                    <h4>NEW ARRIVALS</h4>
                                    <h5>Womens Collection</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <div class="single-product">
                            <a href="product-details.html"><img src="{{asset('front/img/product/product-3.jpg')}}" alt="">
                                <div class="product-text">
                                    <h4>FASIONABLE</h4>
                                    <h5>Bag Collection</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                        <div class="single-product">
                            <a href="product-details.html"><img src="{{asset('front/img/product/product-4.jpg')}}" alt="">
                                <div class="product-text">
                                    <h4>WOMEN'S</h4>
                                    <h5>Trendy Collection</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-carousel-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div role="tabpanel">
                            <ul role="tablist" class="features-menu">
                                <li role="presentation" class="active"><a data-toggle="tab" role="tab" aria-controls="recent" href="#recent" aria-expanded="true">Recent</a></li>
                                <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="feature" href="#feature" aria-expanded="false">Featured</a></li>
                                <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="special" href="#special" aria-expanded="false">Special</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tab-content">
                        <div id="recent" role="tabpanel" class="tab-pane active">
                            <div class="single-p-slide">
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-25.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-16.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Aenean Sagittis </a><span class="line">$135</span><span>$125</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-7.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-20.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Elemtum Felis </a><span class="line">$175</span><span>$150</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-8.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-19.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$195</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-23.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Phasellus Vel </a><span class="line">$190</span><span>$175</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-25.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-16.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$170</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="feature" role="tabpanel" class="tab-pane">
                            <div class="single-p-slide">
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-21.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Phasellus Vel </a><span class="line">$190</span><span>$175</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-19.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Aenean Sagittis </a><span class="line">$135</span><span>$125</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-7.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-21.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Elemtum Felis </a><span class="line">$175</span><span>$150</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-8.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-16.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$195</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-16.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$170</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="special" role="tabpanel" class="tab-pane">
                            <div class="single-p-slide">
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-7.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-20.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Elemtum Felis </a><span class="line">$175</span><span>$150</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-8.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-16.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="#" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="cart.html">Feugiat Lacinia </a><span class="line">$120</span><span>$195</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-19.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$170</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-21.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Phasellus Vel </a><span class="line">$190</span><span>$175</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-6.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-19.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Aenean Sagittis </a><span class="line">$135</span><span>$125</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 single-product-items">
                                    <div class="single-items">
                                        <a href="product-details.html">
                                            <img class="primary-img" src="{{asset('front/img/product/product-5.jpg')}}" alt="">
                                            <img class="secondary-img" src="{{asset('front/img/product/product-9.jpg')}}" alt="">
                                        </a>
                                        <div class="product-hover">
                                            <div class="product-links">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-exchange"></i></a>
                                            </div>
                                            <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                            <i class="fa fa-star color"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End of Product Area-->
    <!--Product Banner Area Start-->
    <section class="product-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="product-left-banner">
                        <a href="#">
                            <img src="{{asset('front/img/banner/product-banner-1.jpg')}}" alt="img12"/>
                            <div class="banner-left-text">
                                <h2><span class="padding">Biggest Sale </span><span>of the year</span></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="product-left-banner right">
                        <a href="#">
                            <img src="{{asset('front/img/banner/product-banner-2.jpg')}}" alt="img12"/>
                            <div class="banner-left-text">
                                <h2><span class=""> Sale </span><span>up to</span><span>35% OFF</span></h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End of Product Banner Area-->
    <!--Product Bottom Carousel Area Start-->
    <section class="product-bottom-carousel-area">
        <div class="product-carousel-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="b-c-heading">
                            <h1>BEST SELLING</h1>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tab-content">
                        <div class="single-p-slide fade active in" role="tabpanel">
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-10.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-15.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-11.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-22.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Aenean Sagittis </a><span class="line">$135</span><span>$125</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-12.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-17.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Elemtum Felis </a><span class="line">$175</span><span>$150</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-13.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-26.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$195</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-14.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-18.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Phasellus Vel </a><span class="line">$190</span><span>$175</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-10.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-15.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Etiam Eu Neque </a><span class="line">$120</span><span>$100</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 single-product-items">
                                <div class="single-items">
                                    <a href="product-details.html">
                                        <img class="primary-img" src="{{asset('front/img/product/product-11.jpg')}}" alt="">
                                        <img class="secondary-img" src="{{asset('front/img/product/product-24.jpg')}}" alt="">
                                    </a>
                                    <div class="product-hover">
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-exchange"></i></a>
                                        </div>
                                        <div class="p-bottom-cart">
                                            <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4><a href="#">Feugiat Lacinia </a><span class="line">$120</span><span>$170</span></h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End of Product Bottom Carousel Area-->
@endsection
