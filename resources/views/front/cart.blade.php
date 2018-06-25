@extends('frontlayouts.master')
@section('title', 'Product Cart')
@section('content')

    <!--Cart Main Area Start-->
    <section class="cart-main-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form action="#">
                        <div class="cart-table table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="p-image">Product</th>
                                    <th class="p-name">Product Name</th>
                                    <th class="p-amount">Price</th>
                                    <th class="p-quantity">Quantity</th>
                                    <th class="p-total">Total</th>
                                    <th class="p-action">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                function custom_echo($x, $length)
                                {
                                    if(!empty($x)){
                                        if(strlen($x)<=$length)
                                        {
                                            echo $x;
                                        }
                                        else
                                        {
                                            $y=substr($x,0,$length) . '...';
                                            echo $y;
                                        }
                                    }else{
                                        echo "";
                                    }

                                }
                                ?>
                                @if($products)
                                    @foreach($products as $key=>$val)
                                        <tr class="tr">

                                            <td class="p-image">
                                                <a href="/product-details/{{$val['product_slug']}}">
                                                    @foreach($val['product_image'] as $key=>$sin_img)

                                                        @if(isset($sin_img['product_id']))
                                                            <img alt="" src="{{ asset('uploads/product/'.$sin_img['image_name']) }}" width="100px">
                                                        @else
                                                            <img alt="" src="{{ asset('uploads/main_product/'.$sin_img['image_name']) }}" width="100px">
                                                        @endif

                                                    @endforeach
                                                </a>
                                            </td>
                                            <td class="p-name">
                                                <a href="/product-details/{{$val['product_slug']}}">{{$val['product_name']}}</a>

                                                <p><?php custom_echo($val['product_description'], 70); ?></p>
                                                <p class="c-p-size"><span>Variant : </span> {{$val['product_variant']['combination']}}</p>
                                            </td>
                                            <?php
                                                if($val['product_variant']['price'] != ""){
                                                    $price = $val['product_variant']['price'];
                                                }else{
                                                    $price = $val['sell_price'];
                                                }
                                            ?>
                                            <td class="p-amount"><span class="amount">Rs. {{$price}}</span></td>
                                            <td class="p-quantity"><input class="single_amount" type="text" value="1" data-amount="{{$price}}"></td>
                                            <td>Rs. <span class="p-total">{{$price}}</span></td>
                                            <td class="p-action"><a href="javascript:;" onclick="removeIteml('{{$val['id']}}','{{$val['product_variant']['id']}}')"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endif
                                
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-6">
                                <div class="cart-coupn-leftside">
                                    <a href="/" class="continue-s">Continue Shopping</a>
                                    <h4>DISCOUNT COUPON CODE</h4>
                                    <div class="dis-coupn-code">
                                        <input type="text" placeholder="DISCOUNT COUPON CODE HERE...">
                                        <input type="button" class="c-submit" value="Apply Coupon">
                                    </div>
                                    <p><span>NOTE :</span> Shipping and Taxes are estimated and updated during checkout based on your billing and shipping information.</p>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6">
                                <div class="cart-coupon-rightside">
                                    {{--<div class="r-c-btn">--}}
                                        {{--<a href="#" class="continue-s">Clear Shopping Cart</a>--}}
                                        {{--<a href="#" class="continue-s">Update Shopping Cart</a>--}}
                                    {{--</div>--}}
                                    <div class="amount-table table-responsive">
                                        <table>
                                            <tbody>
                                            {{--<tr class="s-tGrand Total	otal">
                                                <td>Subtotal</td>
                                                <td>$420</td>
                                            </tr>--}}
                                            <tr class="g-total">
                                                <td>Grand Total</td>
                                                <td>RS. <span>0</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if( session()->get('userDataFront')  && !empty( session()->get('userDataFront') ) ){ ?>
                                        <a href="javascript:;" class="checkout" id="checkout_model">Proceed to check Out</a>
                                    <?php }else{ ?>
                                        <a href="javascript:;" class="checkout non_login">Proceed to check Out</a>
                                        <a href="{{url('login-register')}}" class="login" style="display: none;"></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--End of Cart Main Area-->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Provide Your Address And Countinue To Checkout</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/ckeckout" method="POST" id="check_out_form_submit">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="contact-left-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p>Full Name *</p>
                                            <input type="text" name="name" placeholder="Full Name" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p>Mobile Number *</p>
                                            <input type="text" name="mobile" placeholder="Mobile Number" required>
                                        </div>
                                    </div>

                                    <p>Address Line 1 *</p>
                                    <input type="text" name="address_1" placeholder="address Line 1" required>
                                    <span><p class="help-block">Street address, P.O. box, company name, c/o</p></span>

                                    <p>Address Line 2 *</p>
                                    <input type="text" name="address_2" placeholder="Address Line 2" required>
                                    <span><p class="help-block">Apartment, suite , unit, building, floor, etc.</p></span>

                                    <p>City / Town *</p>
                                    <input type="text" name="city" placeholder="City / Town"  required>

                                    <div class="row" style="margin-top: 15px">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p>State / Province / Region *</p>
                                            <input type="text" name="region" placeholder="State / Province / Region" placeholder="" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p>Country *</p>
                                            <select id="country" name="country">
                                                <option value="" selected="selected">(please select a country)</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia</option>
                                                <option value="BA">Bosnia and Herzegowina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, the Democratic Republic of the</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">Cote d'Ivoire</option>
                                                <option value="HR">Croatia (Hrvatska)</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="TP">East Timor</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="FX">France, Metropolitan</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard and Mc Donald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran (Islamic Republic of)</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libyan Arab Jamahiriya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macau</option>
                                                <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="AN">Netherlands Antilles</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">Reunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint LUCIA</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SK">Slovakia (Slovak Republic)</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SH">St. Helena</option>
                                                <option value="PM">St. Pierre and Miquelon</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands (British)</option>
                                                <option value="VI">Virgin Islands (U.S.)</option>
                                                <option value="WF">Wallis and Futuna Islands</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="YU">Yugoslavia</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="Submit" style="margin-top: 15px;" class="btn btn-primary" value="Check Out">Check Out</button>  Total : RS. <span class="g-total"><span></span></span>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js" type="text/javascript"></script>
    <style type="text/css">
        input, select {
            border: 1px solid #cccccc;
            height: 32px;
            width: 100%;
            padding: 0 10px;
        }
        .contact-left-form {
             margin-top: 0px;
        }
        .error{
            color: #ff5c5c ;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function () {

            $('form[id="check_out_form_submit"]').validate({
                rules: {
                    name: 'required',
                    mobile: 'required',
                    address_1: 'required',
                    address_2: 'required',
                    city: 'required',
                    region: 'required',
                    country: 'required',
                },
                messages: {
                    name : 'Name is required field',
                    mobile : 'Mobile is required field',
                    address_1 : 'Address Line One is required field',
                    address_2 : 'Address Line Two is required field',
                    city : 'City is required field',
                    region : 'Region is required field',
                    country : 'Country is required field'

                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $(".non_login").click(function () {
                $.confirm({
                    title: 'Information',
                    content: 'For the check-out please login.',
                    buttons: {
                        Login: function(){
                            location.href = $('.login').attr('href');
                        }
                    },
                    closeIcon: true
                });
            });

            $('#checkout_model').click(function () {
                var total = parseInt($(".g-total").find('span').html());
                if(total > 0){
                    $("#myModal").modal('show');
                } else {
                    $.dialog({
                        title: 'Dear Customer',
                        content: 'Please Select Item For Check-Out.'
                    });
                }
            });
        });

        function findTotal() {
            var total = 0;
            $('.tr').each(function () {
                total = total + parseInt($(this).find('.p-total').html());
            });
            $(".g-total").find('span').html(total);
        }
        $(document).ready(function () {
            $(".single_amount").change(function() {
                if($(this).val() != ""){
                    var price = parseInt($(this).data('amount')) * $(this).val();
                    $(this).parent().parent().find('.p-total').html(price);
                }
                findTotal();
            });
            findTotal();
        });

        function removeIteml(product_id, variant_id) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete this item?',
                buttons: {
                    confirm: function () {
                        var data = getCookie('product_details');
                        var product_details = JSON.parse(data);
                        $.each(product_details,function (key,val) {
                            if(val.product_id == product_id && val.product_variant_id == variant_id){
                                product_details.shift(key);
                                //window.location.reload();
                            }
                        });
                        var details = "";
                        if(product_details.length > 0){
                             details = JSON.stringify(product_details);
                        }
                        setCookie("product_details",details,30);
                        window.location.reload();
                        //console.log(product_details)
                    },
                    cancel: function () {

                    }
                }
            });

        }

    </script>

@endpush