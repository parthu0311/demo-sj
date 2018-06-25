<?php
/*echo '<pre>';
            print_r($categories); exit;*/
 ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="mainmenu">
                <nav>
                    <ul id="nav">
                        <li class="current"><a href="/">HOME</a></li>
                        @if(isset($categories) && $categories != null && !empty($categories))
                            @foreach($categories as $category)
                                <li><a href="{{ url('/') }}">{{ $category['name'] }}</a>
                                    @if(isset($category['subCategoryOne']) && count($category['subCategoryOne']))
                                        <div class="megamenu">
                                            @foreach($category['subCategoryOne'] as $subCategoryOne)
                                            <?php /*print_r($subCategoryOne); exit;*/ ?>
                                                <span>
                                                    <a href="{{ url('/product-category/'.$subCategoryOne['sub_category_slug']) }}"
                                                       class="mega-title">{{ $subCategoryOne['name'] }}</a>
                                                    @if(isset($subCategoryOne['subCategoryTwo']) && count($subCategoryOne['subCategoryTwo']) > 0)
                                                        @foreach($subCategoryOne['subCategoryTwo'] as $subCategoryTwo)
                                                            <a href="{{ url('/product/'.$subCategoryTwo['sub_category_slug']) }}">{{ $subCategoryTwo['name'] }}</a>
                                                        @endforeach
                                                    @endif
											    </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul>
                            <li><a href="index.html">Home</a>
                                <ul>
                                    <li><a href="index.html">Home 1</a></li>
                                    <li><a href="index-two.html">Home 2</a></li>
                                    <li><a href="index-three.html">Home 3</a></li>
                                </ul>
                            </li>
                            <li><a href="about-us.html">About</a>
                            <li><a href="blog.html">blog</a>
                                <ul>
                                    <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                    <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                    <li><a href="blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="shop.html">Shop</a>
                                <ul>
                                    <li><a href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                    <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                    <li><a href="product-details.html">Shop Fullwidth</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Pages</a>
                                <ul>
                                    <li><a href="cart.html">Cart</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="comming-soon.html">Commingsoon</a></li>
                                    <li><a href="login-register.html">My Account</a></li>
                                    <li><a href="404.html">404 Error</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area end -->