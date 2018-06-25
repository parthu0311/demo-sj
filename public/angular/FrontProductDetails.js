'use strict';
angular.module('app')
    .controller('FrontProductDetailsController', function($rootScope,$scope,$localStorage,$location,$resource,$timeout,$http,$compile, ApiService, ApiEndpoint) {

        function setCookie(cname,cvalue,exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        var data = getCookie('product_details');
        if(data != undefined && data != ""){

            var product_details = JSON.parse(data);

            $.each(product_details,function (key,val) {
                if(val.product_id == $("#product_id").val()){
                    $("#add_to_cart").css("display","none");
                    $("#already_to_cart").css("display","inline");
                    $.confirm({
                        title: 'Encountered an notice !',
                        content: 'This product is already added in card. Please make payment.',
                        type: 'orange',
                        typeAnimated: true,
                        closeIcon: true,
                        boxWidth: '500px',
                        useBootstrap: false
                    });
                }
            });
        }else{
            var product_details = [];
        }
        //console.log(data)

        $(document).on("click","#add_to_cart",function(){

            var obj = {product_id:$("#product_id").val(), product_variant_id:$("#product_variant_id").val()};
            product_details.push(obj);

            //$localStorage.cart = JSON.stringify(product_details);
            var details = JSON.stringify(product_details);
            setCookie("product_details",details,30);
            window.location.reload();
        });

    });
