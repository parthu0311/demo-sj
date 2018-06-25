<?php
$bodyClass = "shop-main sidebar";
?>
@extends('frontlayouts.master')
@section('title', 'Product detail')
@section('content')

    <div class="shop-left-sidebar-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="blog-left-sidebar">
                        <form method="GET" id="filter_form">
                           <input type="hidden" name="sub-category" value="{{Input::get('sub-category')}}">

                           <input type="hidden" name="brand" value="{{Input::get('brand')}}">   
                           <input type="hidden" name="price" value="value="{{Input::get('price')}}"">
                        </form>
                        <ul class="l-sidebar blog">

                            <li><a href="#" class="left-sidebar-title">Filter Section </a></li>

                            @if(isset($sub_categories) && !empty($sub_categories))
                                
                                    <li>
                                        <a href="#" class="show-submenu 
                                            <?php 
                                    if( !empty(Input::get('sub-category') ) )
                                    { echo "submenu-active"; } ?>
                                        ">Categories
                                            <i class="fa fa-plus plus"></i>
                                            <i class="fa fa-minus minus"></i>
                                        </a>
                                        
                                            <ul class="left-sub-navbar submenu  
                                            <?php 
                                    if( !empty(Input::get('sub-category')) )
                                    { echo "submenu-active"; } ?>
                                            ">
                                                @foreach($sub_categories as $FilterKey)
                                                    <li>

                                                        <a href="#" data-id="{{ $FilterKey['id'] }}">
                                                           <input class="change_filter" 
                                                                type="checkbox" 
                                                                name="sub-category"
                                                                value="{{rawurlencode($FilterKey['sub_category_slug'] )}}"
                            <?php 
                                if( !empty(Input::get('sub-category')) )
                                    {
                                        $dt = Input::get('sub-category');
                                        //echo $dt; exit;
                                        $temp = explode(',', $dt);
                                        if(in_array($FilterKey['sub_category_slug'] , $temp)){
                                                echo "checked='checked'";
                                            }
                                    } 
                            ?>
                                                                >  

                                                            {{ $FilterKey['sub_category_name'] }}
                                                        </a>
                                                            
                                                        
                                                    </li>
                                                @endforeach
                                            </ul>
                                       
                                    </li>
                                
                            @endif

                            @if(isset($Brands) && !empty($Brands))
                                
                                    <li>
                                        <a href="#" class="show-submenu 
                                            <?php 
                                    if( !empty(Input::get('brand') ) )
                                    { echo "submenu-active"; } ?>
                                        ">Brands
                                            <i class="fa fa-plus plus"></i>
                                            <i class="fa fa-minus minus"></i>
                                        </a>
                                        
                                            <ul class="left-sub-navbar submenu  
                                            <?php 
                                    if( !empty(Input::get('brand')) )
                                    { echo "submenu-active"; } ?>
                                            ">
                                                @foreach($Brands as $FilterKey)
                                                    <li>

                                                        <a href="#" data-id="{{ $FilterKey['id'] }}">
                                                           <input class="change_filter" 
                                                                type="checkbox" 
                                                                name="brand"
                                                                value="{{rawurlencode($FilterKey['id'] )}}"
                            <?php 
                                if( !empty(Input::get('brand')) )
                                    {
                                        $dt = Input::get('brand');
                                        //echo $dt; exit;
                                        $temp = explode(',', $dt);
                                        if(in_array($FilterKey['id'] , $temp)){
                                                echo "checked='checked'";
                                            }
                                    } 
                            ?>
                                                                >  

                                                            {{ $FilterKey['product_brand_name'] }}
                                                        </a>
                                                            
                                                        
                                                    </li>
                                                @endforeach
                                            </ul>
                                       
                                    </li>
                                
                            @endif
                        </ul>
                        
                       
                        <aside class="widget-price">
                            <h3 class="sidebar-sub-title">price</h3>
                            <div class="price_filter">
                                <div id="slider-range"></div>
                                <div class="price_slider_amount">
                                    <input type="text" id="amount" name="price" placeholder="Add Your Price"/>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-md-9 right-side-p">
                    <div class="row">
                        <div class="shop-item-filter">
                            <div class="filter-text">
                                <p>Showing 1 to 15 of {{ $products->total() }} (for page 1)</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        @if(isset($products) && !empty($products) )
                            @foreach($products as $single)

                            <div class="single-product-items">
                                <div class="single-items">
                                    <a href="/product-details/{{$single->product_slug}}">

                                        @foreach($single['product_image'] as $key=>$sin_img)

                                        @if(isset($sin_img['product_id']))
                                        <img style="height: 283px;width: 210px"  
                                        class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" 
                                        src="{{ asset('uploads/product/'.$sin_img['image_name']) }}" alt="">
                                        @else
                                        <img style="height: 283px;width: 210px"  
                                        class="<?php if($key==0){ echo 'primary-img';}else{echo 'secondary-img';} ?>" src="{{ asset('uploads/main_product/'.$sin_img['image_name']) }}" alt="">
                                        @endif
                                        
                                        @endforeach
                                        
                                        <!-- <img style="height: 283px;width: 210" class="secondary-img" src="{{ asset('uploads/main_product/'.$single['product_image'][1]['image_name']) }}"
                                             alt=""> -->
                                        <span class="image-text-bg"></span>
                                        <span class="image-text">SALE</span>
                                    </a>
                                
                                </div>
                                <div class="product-info">
                                    <h4><a href="/product-details/{{$single->product_slug}}">{{$single['product_name']}} </a>
                                        <span class="line">Rs.{{$single['mrp']}}</span><span>Rs.{{$single['sell_price']}}</span>
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
                            
                        @endif
                    </div>
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="pagination">
                                <?php /*echo '<pre>'; print_r($new_arr_input); exit;*/ ?>
                                {{ $products->appends(Input::all())->links()}}
                                <!-- <ul>
                                    <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>.....</li>
                                    <li><a href="#">19</a></li>
                                    <li><a href="#">20</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <style type="text/css">
        .pagination ul li > span {
        border: 1px solid #ff5555;
        border-radius: 50%;
        color: #ff5555;
        display: inline-block;
        font-family: "montserratsemi_bold";
        font-size: 12px;
        height: 25px;
        padding-top: 4px;
        text-align: center;
        width: 25px;
    }
    </style>
    <script>
        var data = [];
        var input_set = "";
        $(".change_filter").change(function() {
            var input_set  = $(this).attr('name');
            $('input[name=\''+$(this).attr('name')+'\']').each(function () {
                if ($(this).is(':checked')) {
                    data.push($(this).val());
                }
            });
            //alert(decodeURIComponent(input_set));
            $("#filter_form").find('input[name=\''+input_set+'\']').val(data.join(','));
            $("#filter_form").submit();
        })

        
         var filter_price = '<?php echo Input::get('price'); ?>';

            if(filter_price != "" && filter_price != null && filter_price != undefined){
                //alert(filter_price.split(',')[1])
                $( "#slider-range" ).slider({
                    range: true,
                    min: <?php echo (float) ceil(($priceFilter->minPrice - 100 ) / 100 ) * 100; ?>,
                    max: <?php echo (float) ceil($priceFilter->maxPrice / 100 ) * 100; ?>,
                    values: [ filter_price.split(',')[0], filter_price.split(',')[1] ],
                    slide: function( event, ui ) {
                        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    }
                });
                
                
            }else{

                $( "#slider-range" ).slider({
                    range: true,
                    min: <?php echo (float) ceil($priceFilter->minPrice / 100 ) * 100; ?>,
                    max: <?php echo (float) ceil($priceFilter->maxPrice / 100 ) * 100; ?>,
                    values: [ <?php echo $priceFilter->minPrice; ?>, <?php echo $priceFilter->maxPrice; ?> ],
                    slide: function( event, ui ) {
                        //alert("Dsf");
                        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    }
                });

            }

            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        $(document).ready(function(){
           


           $( "#slider-range" ).find('span').click(function(){
                $("#filter_form").find('input[name=price]').val($("#slider-range").slider( "values", 0 ) +
                "," + $( "#slider-range" ).slider( "values", 1 ));
                $("#filter_form").submit();
            })
           $("#filter_form").find('input[name=price]').val($("#slider-range").slider( "values", 0 ) +
                "," + $( "#slider-range" ).slider( "values", 1 ));
        
           
        })
        
        
        /*$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );*/
    </script>
@endpush
