<!--Header Top Area Start-->
<?php if( session()->get('userDataFront')  && !empty( session()->get('userDataFront') ) ){
    $usersData = session()->get('userDataFront');

} ?>
<?php /*echo '<pre>';
print_r($usersData);
echo '</pre>';
die;*/ ?>
<header>
  <div class="header-top-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="header-top-left-menu">
            <nav>
              <ul>
                <?php if( session()->get('userDataFront')  && !empty( session()->get('userDataFront') ) ){ ?>
                  <li><a href="#"><i class="fa fa-user"></i>My Account</a></li>
                <?php } ?>
                <li><a href="#"><i class="fa fa-heart"></i>Wish List <span>(0)</span></a></li>
                <li><a href="/cart"><i class="fa fa-shopping-cart"></i>Shopping Cart</a></li>
                <li><a href="#"><i class="fa fa-share-square-o"></i>Checkout</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="header-top-right-menu">
            <nav>
              <ul>
                <?php if( session()->get('userDataFront')  && !empty( session()->get('userDataFront') ) ){ ?>
                <li><a href="#"><strong>Welcome : </strong> {{$usersData->first_name}} {{$usersData->last_name}}</a></li>
                <?php } ?>
                {{--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">USD<i class="fa fa-angle-down"></i></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">&euro; EURO</a></li>
                    <li><a href="#">&pound; POUND</a></li>
                    <li><a href="#">&yen; YEN</a></li>
                  </ul>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{asset('front/img/flag.png')}}" alt="">English<i class="fa fa-angle-down"></i></a>
                  <ul class="dropdown-menu lang">
                    <li><a href="#">USA</a></li>
                    <li><a href="#">UK</a></li>
                    <li><a href="#">GERMAN</a></li>
                  </ul>
                </li>--}}
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-main-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="contact-info-header">
            <div class="contact-icon">
              <i class="fa fa-phone"></i>
            </div>
            <div class="contact-text">
              <p>+88 (012) 564 979 56</p>
              <span>We are open 9 am - 10pm</span>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="logo">
            <a href="#"><img src="{{asset('front/img/logo.png')}}" alt="Galleria"></a>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="register">
            <ul>
              <?php if( session()->get('userDataFront')  && !empty( session()->get('userDataFront') ) ){ ?>

              <li><a href="/logout"><i class="fa fa-share-square-o"></i>LogOut</a></li>
              <?php }else{ ?>
              <li><a href="/login-register"><i class="fa fa-share-square-o"></i>Login</a></li>
              <li><a href="/login-register"><i class="fa fa-lock"></i>Register</a></li>
              <?php } ?>
            </ul>
            <ul class="header-main-right">
              <li><a href="/cart" class="cart"><i class="fa fa-shopping-cart"></i><span id="cart_count"></span></a>
                {{--<div class="mini-cart-content">
                  <div class="mini-top-sec">
                    <div class="cart-image">
                      <a href="#"><img src="{{asset('front/img/cart-1.jpg')}}" alt=""></a>
                      <span class="quantity">1</span>
                    </div>
                    <div class="cart-info">
                      <a href="#"><p>Etiam Eu Neque</p></a>
                      <p class="cart-price">£300.00</p>
                    </div>
                    <div class="product-cancel"><a href="#"><i class="fa fa-times-circle"></i></a>
                    </div>
                  </div>
                  <div class="mini-top-sec">
                    <div class="cart-image">
                      <a href="#"><img src="{{asset('front/img/cart-2.jpg')}}" alt=""></a>
                      <span class="quantity">2</span>
                    </div>
                    <div class="cart-info">
                      <a href="#"><p>Etiam Eu Neque</p></a>
                      <p class="cart-price">£500.00</p>
                    </div>
                    <div class="product-cancel"><a href="#"><i class="fa fa-times-circle"></i></a>
                    </div>
                  </div>
                  <div class="mini-bottom-sec">
                    <p class="total-amount">AMOUNT <span>£800.00</span></p>
                    <div class="button"><a href="#">CHECKOUT</a></div>
                  </div>
                </div>--}}
              </li>
            </ul>
          </div>
          <div class="search-form">
            <form id="search-form" action="#">
              <input type="search" placeholder="" name="s" />
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--End of Header Top Area-->