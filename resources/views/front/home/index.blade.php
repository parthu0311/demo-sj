@extends('frontlayouts.master')
@section('title', 'Best Product Ever Fro Buying')
@section('content')
    @if(isset($homeSliders) && $homeSliders != null)
        <!--Slider Area Start-->
        <div class="slider-area">
            <div class="fullwidthbanner-container">
                <div class="fullwidthbanner">
                    <ul>
                        @foreach($homeSliders as $homeSlider)
                            <li class="slider" data-transition="random" data-slotamount="7" data-masterspeed="300">
                                <!-- Main Image-->
                                <a href="{{$homeSlider['url']}}">
                                <img src="{{ url('uploads/banner_image/'.$homeSlider['image']) }}"
                                     alt="{{ $homeSlider['name'] }}"
                                     data-bgposition="center top" data-bgrepeat="no-repeat"
                                     data-bgpositionend="center center">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    <!--End of Slider Area-->
    <!--Product Area Start-->
    <section class="product-area">
        <div class="product-top-area">
            <div class="container">
                <div class="row">
                    @if(isset($homeCollectionSliders) && !empty($homeCollectionSliders))
                        @foreach($homeCollectionSliders as $homeCollectionSlider)
                            <div class="col-lg-3 col-md-3 col-sm-4">
                                <div class="single-product">
                                    <a href="/product-collection/{{$homeCollectionSlider['collection_slug']}}"><img
                                                src="{{ url('uploads/collection_image/'.$homeCollectionSlider['image']) }}"
                                                alt="">
                                        <div class="product-text">
                                            <h4>{{ $homeCollectionSlider['collection_for'] }}</h4>
                                            <h5>{{ $homeCollectionSlider['collection_summery'] }}</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="product-carousel-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div role="tabpanel">
                            @if(isset($homeCollectionTags) && !empty($homeCollectionTags))
                                <ul role="tablist" class="features-menu">
                                    @foreach($homeCollectionTags as $homeCollectionTagKey => $homeCollectionTagValue)
                                        <li role="presentation" class="{{ ($homeCollectionTagKey == 0)?'active':'' }}">
                                            <a data-toggle="tab" role="tab"
                                               aria-controls="{{preg_replace('/\s+/', '',$homeCollectionTagValue['name']) }}"
                                               href="#{{preg_replace('/\s+/', '',$homeCollectionTagValue['name']) }}"
                                               aria-expanded="true">{{ $homeCollectionTagValue['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @if(isset($homeCollectionTags) && !empty($homeCollectionTags))
                        <div class="tab-content">
                            @foreach($homeCollectionTags as $TagKey => $TagValue)
                            <div id="{{preg_replace('/\s+/', '',$TagValue['name']) }}" role="{{preg_replace('/\s+/', '',$TagValue['name']) }}" 
                            class="tab-pane <?php if($TagKey==0){echo 'active';} ?>">
                                <div class="single-p-slide">
                                    @foreach($TagValue['product'] as $Tkey=>$Tvalue)
                                        <div class="col-lg-4 col-md-4 single-product-items">
                                        <div class="single-items">
                                            <a href="/product-details/{{$Tvalue['product_slug']}}">

                                                @foreach($Tvalue['product_image'] as $key=>$sin_img)
                                                @if(isset($sin_img['product_id']))
                                                <img style="height: 283px;width: 210px"  
                                                class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" 
                                                src="{{ asset('uploads/product/'.$sin_img['image_name']) }}" alt="">
                                                @else
                                                <img style="height: 283px;width: 210px"  
                                                class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" src="{{ asset('uploads/main_product/'.$sin_img['image_name']) }}" alt="">
                                                @endif
                                                
                                                @endforeach
                                            </a>
                                            <!-- <div class="product-hover">
                                                <div class="product-links">
                                                    <a href="#"><i class="fa fa-search"></i></a>
                                                    <a href="#"><i class="fa fa-heart"></i></a>
                                                    <a href="#"><i class="fa fa-exchange"></i></a>   
                                                </div>
                                            </div> -->
                                            <!-- <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div> -->
                                        </div>
                                        <div class="product-info">
                                            <h4><a href="/product-details/{{$Tvalue['product_slug']}}">{{$Tvalue['product_name']}} </a>
                                                <span class="line">Rs.{{$Tvalue['mrp']}}</span><span>Rs.{{$Tvalue['sell_price']}}</span>
                                            </h4>
                                            <!-- <div class="product-rating">
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                    @endforeach
                                      
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--End of Product Area-->
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
                            @foreach($BestSelling as $Tkey=>$Tvalue)
                                        <div class="col-lg-4 col-md-4 single-product-items">
                                        <div class="single-items">
                                            <a href="/product-details/{{$Tvalue['product_slug']}}">

                                                @foreach($Tvalue['product_image'] as $key=>$sin_img)
                                                @if(isset($sin_img['product_id']))
                                                <img style="height: 283px;width: 210px"  
                                                class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" 
                                                src="{{ asset('uploads/product/'.$sin_img['image_name']) }}" alt="">
                                                @else
                                                <img style="height: 283px;width: 210px"  
                                                class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" src="{{ asset('uploads/main_product/'.$sin_img['image_name']) }}" alt="">
                                                @endif
                                                
                                                @endforeach
                                            </a>
                                            <!-- <div class="product-hover">
                                                <div class="product-links">
                                                    <a href="#"><i class="fa fa-search"></i></a>
                                                    <a href="#"><i class="fa fa-heart"></i></a>
                                                    <a href="#"><i class="fa fa-exchange"></i></a>   
                                                </div>
                                            </div> -->
                                            <!-- <div class="p-bottom-cart">
                                                <a href="cart.html" class="hover-cart">ADD TO <span>CART</span></a>
                                            </div> -->
                                        </div>
                                        <div class="product-info">
                                            <h4><a href="/product-details/{{$Tvalue['product_slug']}}">{{$Tvalue['product_name']}} </a>
                                                <span class="line">Rs.{{$Tvalue['mrp']}}</span><span>Rs.{{$Tvalue['sell_price']}}</span>
                                            </h4>
                                            <!-- <div class="product-rating">
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                                <i class="fa fa-star color"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                    @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End of Product Bottom Carousel Area-->
    <!--Blog Brand Area Start-->
   <!--  <section class="blog-brand-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="blog-area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="blog-title">
                                    <h2>FROM BLOG</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="single-blog">
                                    <div class="blog-image">
                                        <a href="blog-details.html">
                                            <img src="{{ url('front') }}/img/blog/blog-1.jpg" alt="">
                                        </a>
                                        <a href="blog.html">
                                            <div class="date">
                                                <h2><span>12</span>NOV</h2>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="blog-text">
                                        <h3><a href="blog-details.html">Lorem ispam doler</a></h3>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accustium
                                            doloremque laudantium...</p>
                                        <div class="post_info">
                                            <p class="author">
                                                <i class="fa fa-edit"></i>
                                                <span><a href="#">Jhon</a></span>
                                            </p>
                                            <p class="time-count">
                                                <i class="fa fa-calendar"></i>
                                                <span class="count">2 Days ago</span>
                                            </p>
                                            <p class="comments">
                                                <i class="fa fa-comments"></i>
                                                <span><a href="#">12 Comments</a></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 hidden-sm">
                                <div class="single-blog">
                                    <div class="blog-image">
                                        <a href="blog-details.html">
                                            <img src="{{ url('front') }}/img/blog/blog-2.jpg" alt="">
                                        </a>
                                        <a href="blog.html">
                                            <div class="date">
                                                <h2><span>28</span>OCT</h2>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="blog-text">
                                        <h3><a href="blog-details.html">Omnis iste natus</a></h3>
                                        <p>Voluptatem accustium doloremque Sed ut perspiciatis unde omnis iste natus
                                            error sit laudantium...</p>
                                        <div class="post_info">
                                            <p class="author">
                                                <i class="fa fa-edit"></i>
                                                <span><a href="#">Jhon</a></span>
                                            </p>
                                            <p class="time-count">
                                                <i class="fa fa-calendar"></i>
                                                <span class="count">2 Days ago</span>
                                            </p>
                                            <p class="comments">
                                                <i class="fa fa-comments"></i>
                                                <span><a href="#">12 Comments</a></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="brand-area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="brand-title">
                                    <h2>OUR BRAND</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-1.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-2.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-3.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-4.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-5.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-6.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-7.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-8.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="single-brand">
                                    <a href="#"><img src="{{ url('front') }}/img/brand/brand-9.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--End of Blog Brand Area-->
    <!--Service Area Start-->
    <section class="service-area">
        <div class="container">
            <div class="row">
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="{{ url('front') }}/img/serv-1.png" alt="">
                        </div>
                    </div>
                    <h4>High quality</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="{{ url('front') }}/img/serv-2.png" alt="">
                        </div>
                    </div>
                    <h4>Fast delivery</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="{{ url('front') }}/img/serv-3.png" alt="">
                        </div>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="{{ url('front') }}/img/serv-4.png" alt="">
                        </div>
                    </div>
                    <h4>14 - day returns</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="{{ url('front') }}/img/serv-5.png" alt="">
                        </div>
                    </div>
                    <h4>Secure checkout</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
            </div>
        </div>
    </section>
    <!--End of Service Area-->
@endsection