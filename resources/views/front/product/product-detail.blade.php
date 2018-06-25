@extends('frontlayouts.master')
@section('title', 'Product detail')
@section('content')
   <!--Product Details Area Start-->

        <section class="product-details-area" ng-controller="FrontProductDetailsController">
            <input type="hidden" id="product_id" value="{{$products['id']}}">
            <input type="hidden" id="product_variant_id" value="{{$products['variant']['id']}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5">
            <div class="xzoom-container">
          
          
              
            </div>

                <div class="picZoomer">
                    @if(isset($products['variant']['image']) && count($products['variant']['image']) > 0 )
                    <img src="{{asset('uploads/product').'/'.$products['variant']['image'][0]['image']}}" height="320" width="320" alt="">
                    @else
                    @if(isset($products['image']) && count($products['image']))
                    <img src="{{asset('uploads/main_product').'/'.$products['image'][0]['image_name']}}" height="320" width="320" alt="">
                     @endif
                    @endif
                </div>

                <ul class="piclist">
                    @if(isset($products['variant']['image']) && count($products['variant']['image']) > 0)
                    @foreach($products['variant']['image'] as $image)
                    <li><img src="{{asset('uploads/product').'/'.$image['image']}}" alt=""></li>
                    @endforeach
                    @else
                    @if(isset($products['image']) && count($products['image']) > 0)
                    @foreach($products['image'] as $img)
                    <li><img src="{{asset('uploads/main_product').'/'.$img['image_name']}}" alt=""></li>
                    @endforeach
                    @endif
                    @endif
          
                </ul>
                    </div>


                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <div class="product-right-details">
                            <h2>{{$products['product_name']}}</h2>
                            <div class="product-rating">
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                            </div>
                            <p class="review"><a href="#">4 Review (s)  |  Add your review</a></p>
                            <p class="p-d-price">Rs.<?php if(!empty($products['variant']['price'])){
                                                echo $products['variant']['price'];
                                            } else {
                                                echo $products['sell_price'];
                                            }
                                    ?> 
                                <span>
                                Rs.{{$products['mrp']}}
                                </span>
                            </p>
                            <p>Only 25 left      |    Availability : <span class="stock">In Stock </span> </p>
                        </div>
                        <div class="p-d-info">
                            @foreach($products['filter_data'] as $filter_data)
                            <div class="filter-by">
                                <h4>{{$filter_data['field_label']}}</h4>
                                <form action="#">
                                    <div class="select-filter">
                                        <select class="select_teg">
                                          @foreach($filter_data['questionnaire_fields_values'] as $filter)  
                                            <option value="{{$filter['value']}}"
                                                <?php 
                                if( !empty(Input::get(rawurlencode(str_replace(' ', '-','search')))) )
                                    {
                                        $dt = Input::get(rawurlencode(str_replace(' ', '-','search')));
                                        //echo $dt; exit;
                                        $temp = explode('-', $dt);
                                        if(in_array($filter['value'] , $temp)){
                                                echo "selected='selected'";
                                            }
                                    } 
                                ?>
                                            >    {{$filter['value']}}
                                            </option>
                                          @endforeach
                                        </select> 
                                    </div>
                                </form>                             
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="p-d-cart">
                            <a href="javascript:;" id="add_to_cart" class="p-d-btn">ADD TO CART</a>
                            <a href="javascript:;" id="already_to_cart" class="p-d-btn" style="display: none;">ALREADY IN CART</a>
                            <a href="#" class="p-d-fav"><i class="fa fa-heart"></i></a>
                            <!-- <a href="#" class="p-d-search"><i class="fa fa-search"></i></a> -->
                        </div>
                        <div class="share-post">
                            <h3>Share:</h3>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>   
                <div class="row" style="margin-top: 20px">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p>
                            <?php echo html_entity_decode($products['product_description']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!--End of product-details Area-->
        <!--Shop Main Area Start-->
        <section class="shop-main-area details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2>RELATED PRODUCTS</h2>
                    </div>
                </div>
                <div class="row">

                @if(!empty($prod['data']) && count($prod['data']) > 0)
                <?php $p_data = array_chunk($prod['data'],4); ?>    
                <div class="col-md-12">
                    <div id="Carousel" class="carousel slide">
                     
                    <ol class="carousel-indicators">
                        @foreach($p_data as $key => $r)
                        <li data-target="#Carousel" data-slide-to="{{$key}}" class="<?php if($key==0){echo 'active';} ?>"></li>
                        @endforeach
                    </ol>
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        
                    @foreach($p_data as $key => $rele)
                    <div class="item <?php if($key==0){echo 'active';} ?>">
                        <div class="row">
                          @foreach($rele as $key1 => $rele1)
                          <div class="col-md-3">
                            <a href="/product-details/{{$rele1['product_slug']}}" class="thumbnail">
                                @if(isset($rele1['product_image']) && !empty($rele1['product_image']))
                                @if(isset($rele1['product_image'][0]['product_id']))
                                <img src="{{ asset('uploads/product/'.$rele1['product_image'][0]['image_name']) }}" alt="Image" style="height: 283px; width: 210px;">
                                @else
                                <img src="{{ asset('uploads/main_product/'.$rele1['product_image'][0]['image_name']) }}" alt="Image" style="height: 283px; width: 210px;">
                                @endif
                                @endif
                                
                            </a>
                            <div class="product-info">
                                <h4><a href="/product-details/{{$rele1['product_slug']}}">{{$rele1['product_name']}} </a><span class="line">Rs.{{$rele1['mrp']}}</span><span>Rs.{{$rele1['sell_price']}}</span></h4>
                            </div>
                          </div>
                          @endforeach
                          
                        </div><!--.row-->
                    </div><!--.item-->
                     
                     @endforeach
                    </div><!--.carousel-inner-->
                      <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                      <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                    </div><!--.Carousel-->      
                </div>
                @endif  
   
                </div>
            </div>
        </section>
        <!--End of Shop Main Area-->
        
        <!--Service Area Start-->
        <section class="service-area">
            <div class="container">
                <div class="row">
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="img/serv-1.png" alt="">
                            </div>
                        </div>
                        <h4>High quality</h4>
                        <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                    </div>
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="img/serv-2.png" alt="">
                            </div>
                        </div>
                        <h4>Fast delivery</h4>
                        <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                    </div>
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="img/serv-3.png" alt="">
                            </div>
                        </div>
                        <h4>24/7 Support</h4>
                        <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                    </div>
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="img/serv-4.png" alt="">
                            </div>
                        </div>
                        <h4>14 - day returns</h4>
                        <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                    </div>
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="img/serv-5.png" alt="">
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
@push('js')

<style type="text/css">
   
    .piclist{
        margin-top: 30px;
    }
    .piclist li{
        display: inline-block;
        width: 50px;
        height: 50px;
    }
    .piclist li img{
        width: 100%;
        height: auto;
    }

    /* custom style */
    .picZoomer-pic-wp,
    .picZoomer-zoom-wp{
        border: 1px solid #fff;
        background-color: #a7a4a4;
    }

    .carousel {
    margin-bottom: 0;
    padding: 0 40px 30px 40px;
}
/* The controlsy */
.carousel-control {
    left: -12px;
    height: 40px;
    width: 40px;
    background: none repeat scroll 0 0 #222222;
    border: 4px solid #FFFFFF;
    border-radius: 23px 23px 23px 23px;
    margin-top: 90px;
}
.carousel-control.right {
    right: -12px;
}
/* The indicators */
.carousel-indicators {
    right: 50%;
    top: auto;
    bottom: -10px;
    margin-right: -19px;
}
/* The colour of the indicators */
.carousel-indicators li {
    background: #cecece;
}
.carousel-indicators .active {
    background: #428bca;
}

</style>
<script src="{{ asset('angular/FrontProductDetails.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('plugins/Viewer').'/css/jquery-picZoomer.css'}}">
<script type="text/javascript" src="{{asset('plugins/Viewer').'/src/jquery.picZoomer.js'}}"></script>


    <script>
         $(document).ready(function() {
             $('#Carousel').carousel({
                interval: 5000
            });

            $('.picZoomer').picZoomer();

            $('.piclist li').on('click',function(event){
                var $pic = $(this).find('img');
                $('.picZoomer-pic').attr('src',$pic.attr('src'));
            });

            $(document).on('change','.select_teg',function () {
                var temp = [];
                $('.select_teg').each(function(){
                    temp.push($(this).val());
                })
                window.location.href= "{{ url()->current() }}"+'?search='+temp.join('-');
                //console.log($(this).val());
            });


        });
    </script>
@endpush