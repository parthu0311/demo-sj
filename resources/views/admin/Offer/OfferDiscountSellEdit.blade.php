<div class="box-body">
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Coupon Code <span class="asterisk red">*</span></label>
                <input class="form-control" value="{{$Offer->coupon_code}}" placeholder="Coupon Code" type="text" name="coupon_code" id="coupon_code">
                <small class="help-block coupon_code"></small>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Coupon Name <span class="asterisk red">*</span></label>
                <input class="form-control" value="{{$Offer->coupon_name}}" placeholder="Coupon Name" type="text" name="coupon_name" id="coupon_name">
                <small class="help-block coupon_name"></small>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Now Only (Rs.)<span class="asterisk red">*</span></label>
                <input class="form-control" placeholder="Discount" type="text" value="{{$Offer->discount}}" name="discount" id="discount">
                <small class="help-block discount"></small>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Apply to <span class="asterisk red">*</span></label>
                <select class="form-control select2" style="width: 100%;" name="apply_to" id="apply_to">
                    <option value="">Choose One</option>
                    <option value="Specific Product" {{ $Offer->apply_to == 'Specific Product' ? 'selected="selected"' : '' }}>Specific Product</option>
                    <option value="Specific Category" {{ $Offer->apply_to == 'Specific Category' ? 'selected="selected"' : '' }}>Specific Category</option>
                    <option value="Specific Category Type" {{ $Offer->apply_to == 'Specific Category Type' ? 'selected="selected"' : '' }}>Specific Category Type</option>
                </select>
                <small class="help-block apply_to"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6" id="append_apply_to">
            <div class="form-group">
                @if($Offer->apply_to == 'Specific Product')
                    <label>Product <span class="asterisk red">*</span></label>
                    <?php $pro =  \App\Product::where('status','Active')->get(); ?>
                    <select class="form-control select2" style="width: 100%;" name="product" id="product">
                        <option value="">Choose One</option>
                        @foreach($pro as $k=>$v)
                            <option value="{{$v->id}}" {{ $Offer->product_id == $v->id ? 'selected="selected"' : '' }}>{{$v->product_name}}</option>
                        @endforeach
                    </select>
                    <small class="help-block apply_to_on"></small>
                @elseif($Offer->apply_to == 'Specific Category')
                    <label>Category <span class="asterisk red">*</span></label>
                    <?php $Cate =  \App\Categories::where('status','Active')->get(); ?>
                    <select class="form-control select2" style="width: 100%;" name="categories" id="categories">
                        <option value="">Choose One</option>
                        @foreach($Cate as $k=>$v)
                            <option value="{{$v->id}}" {{ $Offer->category_id == $v->id ? 'selected="selected"' : '' }}>{{$v->name}}</option>
                        @endforeach
                    </select>
                    <small class="help-block apply_to_on"></small>
                @elseif($Offer->apply_to == 'Specific Category Type')
                    <label>Category Type <span class="asterisk red">*</span></label>
                    <?php $SubCat =  \App\SubCategories::where('parent','!=',0)->where('status','Active')->get(); ?>
                    <select class="form-control select2" style="width: 100%;" name="sub_category_type" id="sub_category_type">
                        <option value="">Choose One</option>
                        @foreach($SubCat as $k=>$v)
                            <option value="{{$v->id}}" {{ $Offer->category_type_id == $v->id ? 'selected="selected"' : '' }}>{{$v->sub_category_name}}</option>
                        @endforeach
                    </select>
                    <small class="help-block apply_to_on"></small>
                @elseif($Offer->apply_to == 'Specific Brand')
                    <label>Brand <span class="asterisk red">*</span></label>
                    <?php $Brand =  \App\Brand::where('status','Active')->get(); ?>
                    <select class="form-control select2" style="width: 100%;" name="brand" id="brand">
                        <option value="">Choose One</option>
                        @foreach($Brand as $k=>$v)
                            <option value="{{$v->id}}" {{ $Offer->brand_id == $v->id ? 'selected="selected"' : '' }}>{{$v->product_brand_name}}</option>
                        @endforeach
                    </select>
                    <small class="help-block apply_to_on"></small>
                @elseif($Offer->apply_to == 'Minimum Order Subtotal')
                    <label>Minimum subtotal <span class="asterisk red">*</span></label>
                    <input class="form-control" placeholder="Minimum subtotal" type="text" value="{{$Offer->minimum_subtotal}}" name="minimum_subtotal" id="minimum_subtotal">
                    <small class="help-block apply_to_on"></small>
                @endif
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid From <span class="asterisk red">*</span></label>
                <input class="form-control date" placeholder="Valid From" type="text" value="{{date('m-d-Y',strtotime($Offer->valid_from))}}" name="valid_from" id="valid_from">
                <small class="help-block valid_from"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid To</label>
                <input class="form-control date" placeholder="Valid To" type="text" value="{{!empty($Offer->valid_to)?date('m-d-Y',strtotime($Offer->valid_to)):''}}" name="valid_to" id="valid_to">
                <small class="help-block valid_to"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid Unlimited</label><br>
                <input type="checkbox" name="valid_unlimited" id="valid_unlimited" {{$Offer->valid_unlimited=="Yes"?"checked='checked'":''}}>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Limit uses</label>
                <input class="form-control" placeholder="Limit uses" type="text" value="{{!empty($Offer->limit_uses)?$Offer->limit_uses:''}}" name="limit_uses" id="limit_uses">
                <small class="help-block limit_uses"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Limit uses Unlimited</label><br>
                <input type="checkbox" name="limit_uses_unlimited" id="limit_uses_unlimited" {{$Offer->limit_uses_unlimited=="Yes"?"checked='checked'":''}}>
            </div>
        </div>
    </div>
</div>