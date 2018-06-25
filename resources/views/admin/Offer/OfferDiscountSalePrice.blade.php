
<div class="box-body">
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Coupon Code <span class="asterisk red">*</span></label>
                <input class="form-control" placeholder="Coupon Code" type="text" name="coupon_code" id="coupon_code">
                <small class="help-block coupon_code"></small>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Coupon Name <span class="asterisk red">*</span></label>
                <input class="form-control" placeholder="Coupon Name" type="text" name="coupon_name" id="coupon_name">
                <small class="help-block coupon_name"></small>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Now Only (Rs.)<span class="asterisk red">*</span></label>
                <input class="form-control" placeholder="Discount" type="text" name="discount" id="discount">
                <small class="help-block discount"></small>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>Apply to <span class="asterisk red">*</span></label>
                <select class="form-control select2" style="width: 100%;" name="apply_to" id="apply_to">
                    <option value="">Choose One</option>
                    <option value="Specific Product">Specific Product</option>
                    <option value="Specific Category">Specific Category</option>
                    <option value="Specific Category Type">Specific Category Type</option>
                </select>
                <small class="help-block apply_to"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6" id="append_apply_to">

        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid From <span class="asterisk red">*</span></label>
                <input class="form-control date" placeholder="Valid From" type="text" name="valid_from" id="valid_from">
                <small class="help-block valid_from"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid To</label>
                <input class="form-control date" placeholder="Valid To" type="text" name="valid_to" id="valid_to">
                <small class="help-block valid_to"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Valid Unlimited</label><br>
                <input type="checkbox" name="valid_unlimited" id="valid_unlimited">
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Limit uses</label>
                <input class="form-control" placeholder="Limit uses" type="text" name="limit_uses" id="limit_uses">
                <small class="help-block limit_uses"></small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Limit uses Unlimited</label><br>
                <input type="checkbox" name="limit_uses_unlimited" id="limit_uses_unlimited">
            </div>
        </div>
    </div>
</div>