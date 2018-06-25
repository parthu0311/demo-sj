@extends('layouts.master')
@section('title', 'Suril Jain - Re-Order Product Category')
@section('content')

    <div >
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Re-Order Product Category
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-category-list') }}">Product Category List</a></li>
                    <li class="active">Re-Order Product Category</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content contentpanel">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Re-Order Product Category</h3>
                            </div>

                            <!--<div id="product_create"></div>-->
                            <div class="box-body" style="padding: 15px;">

                                <p>Use drag &amp; drop to reorder.</p>

                                <ol class="sortable">

                                    <?php if(count($Categories)>0){ ?>
                                    @foreach($Categories as $cat)
                                    <li id="list_{{$cat['id']}}">
                                        <div>
                                            <span class="disclose"><span></span></span>{{$cat['name']}}
                                        </div>
                                        <?php if(isset($cat['data']) && !empty($cat['data']) ){ ?>
                                        @foreach($cat['data'] as $data)
                                            <ol>
                                                <li id="list_{{$data['id']}}">
                                                    <div>
                                                        <span class="disclose"><span></span></span>{{$data['name']}}
                                                    </div>
                                                </li>
                                            </ol>
                                        @endforeach
                                        <?php } ?>
                                    </li>
                                    @endforeach
                                    <?php } ?>
                                </ol>


                                <div class="box-footer">
                                    <a href="{{ url('/admin/product-category-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                    <button type="button" class="btn btn-primary pull-right"  id="toArray">Submit</button>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>



            </section>
            <!-- /.content -->


        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@endsection


@push('scripts')

    <link rel="stylesheet" href="{{ asset('css/nestedSortable.css') }}">
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" type="text/javascript"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.js"></script><script type="text/javascript">

    jQuery(document).ready(function($) {

        // initialize the nested sortable plugin
        $('.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 2,

            isTree: true,
            expandOnHover: 700,
            startCollapsed: false
        });

        $('.disclose').on('click', function () {
            $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
        });

        $('#toArray').click(function(e) {
            // get the current tree order
            arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});

            // log it
            console.log(arraied);
            $.ajax({
                url: '/admin/CategoryReorderPost',
                type: 'POST',
                data: { tree: JSON.stringify(arraied) },
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            }).done(function(data, status) {
                    //alert(data)
                    if(data == 1){
                        var msg = "Data re-ordered successfully";
                        SuccessMessage(msg);
                    }else {
                        var msg = "Data re-ordered failed";
                        ErrorMessage(msg);
                    }

                })
        });
        });
</script>

@endpush