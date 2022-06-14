@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Add')}} {{trans('file.Sale')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
                        {!! Form::open(['route' => 'sales.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Invoice')}} No</strong></label>
                                            <p><strong>{{'sr-' . date("Ymd") . '-'. date("his")}}</strong> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Customer')}} *</strong></label>
                                            <select name="customer_id" class="selectpicker form-control" required data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                                                @foreach($lsms_customer_list as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone. ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Payment')}} {{trans('file.Status')}}</strong></label>
                                            <select class="form-control" name="payment_status">
                                            <option value="Due">Due</option>
                                            <option value="Paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Payment')}} {{trans('file.Method')}} </strong></label>
                                            <select class="form-control" name="payment_method">
                                            <option value="Cheque">Cheque</option>
                                            <option value="Cash">Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Paid')}} {{trans('file.Amount')}} </strong></label>
                                            <input type="number" name="paid_amount" class="form-control" value="0.00" step="any" />
                                        </div>
                                    </div>
                                </div>
                                <div id="cheque-element" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Cheque')}} No</strong></label>
                                            <input type="text" name="cheque_no" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Cheque')}} {{trans('file.Date')}}</strong></label>
                                            <input id="cheque-date" type="text" name="cheque_date" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_name" id="lsms_productcodeSearch" placeholder="Please type product name and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h5>{{trans('file.Order Table')}} *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{trans('file.Name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th>{{trans('file.Product')}} {{trans('file.Price')}}</th>
                                                        <th>{{trans('file.SubTotal')}}</th>
                                                        <th><i class="fa fa-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2">{{trans('file.Total')}}</th>
                                                    <th colspan="2" id="total-qty">0</th>
                                                    <th id="total">0.00</th>
                                                    <th><i class="fa fa-trash"></i></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_price" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Note')}}</strong></label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-condensed totals">
            <td><strong>{{trans('file.Items')}}</strong>
                <span class="pull-right" id="item">0.00</span>
            </td>
            <td><strong>{{trans('file.Total')}}</strong>
                <span class="pull-right" id="subtotal">0.00</span>
            </td>
            <td><strong>{{trans('file.Grand Total')}}</strong>
                <span class="pull-right" id="grand_total">0.00</span>
            </td>
        </table>
    </div>
</section>
<script type="text/javascript">
var rowindex;
$('.selectpicker').selectpicker({
    style: 'btn-link',
});
//$('#cheque-element').hide();

$('select[name="payment_method"]').on('change', function(){
    if($('select[name="payment_method"]').val() == 'Cheque')
        $('#cheque-element').show();
    else
        $('#cheque-element').hide();
});

    var cheque_date = $('#cheque-date');
    cheque_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

var lsms_product = [ @foreach($lsms_product_list as $product)
        <?php
            $productArray[] =  str_replace('"', '\"', $product->name).'-'.$product->model_no;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $productArray).'"';
            ?> ];

    var lsms_productcodeSearch = $('#lsms_productcodeSearch');

    lsms_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(lsms_product, function(item) {
            return matcher.test(item);
        }));
    },
    response: function(event, ui) {
        if (ui.content.length == 1) {
            var data = ui.content[0].value;
            $(this).autocomplete( "close" );
            productSearch(data);
        };
    },
    select: function(event, ui) {
        var data = ui.item.value;
        productSearch(data);
    }
});


//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    calculateRowProductData();
});
//change product price
$("#myTable").on('input', '.product-price', function() {
    rowindex = $(this).closest('tr').index();
    calculateRowProductData();
});


//Delete product
$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
    if (confirm("Are you sure want to delete?")) {
        rowindex = $(this).closest('tr').index();
        $(this).closest("tr").remove();
        calculateTotal();
    }
    return false;
});

function productSearch(data) {
    $.ajax({
        type: 'GET',
        url: 'lsms_product_search',
        data: {
            data: data
        },
        success: function(data) {
            var flag = 1;
            $(".product-id").each(function(i) {
                if ($(this).val() == data[1]) {
                    rowindex = i;
                    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                    calculateRowProductData();
                    flag = 0;
                }
            });
            $("input[name='product_name']").val('');
            if(flag){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td>' + data[0] + '</td>';
                cols += '<td>' + data[2] + '</td>';
                cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                cols += '<td><input type="number" class="form-control product-price" name="product_price[]" value="' + data[3] + '" step="any" required/></td>';
                cols += '<td class="sub-total">0.00</td>';
                cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.Delete")}}</button></td>';
                cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[1] + '"/>';
                cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                newRow.append(cols);
                $("table.order-list tbody").append(newRow);
                rowindex = newRow.index();
                calculateRowProductData();
            }
        }
    });
}

function calculateRowProductData() {
    var quantity = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
    var product_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-price').val();
    var sub_total = (product_price * quantity);

    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(sub_total.toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));

    calculateTotal();
}

function calculateTotal() {
    //Sum of quantity
    var total_qty = 0;
    $(".qty").each(function() {

        if ($(this).val() == '') {
            total_qty += 0;
        } else {
            total_qty += parseFloat($(this).val());
        }
    });

    $("#total-qty").text(total_qty);
    $('input[name="total_qty"]').val(total_qty);

    //Sum of subtotal
    var total = 0;
    $(".sub-total").each(function() {
        total += parseFloat($(this).text());
    });
    $("#total").text(total.toFixed(2));
    $('input[name="total_price"]').val(total.toFixed(2));

    calculateGrandTotal();
}

function calculateGrandTotal() {

    var item = $('table.order-list tbody tr:last').index();

    var total_qty = parseFloat($('#total-qty').text());
    var subtotal = parseFloat($('#total').text());

    item = ++item + '(' + total_qty + ')';
    var grand_total = subtotal;
    
    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#grand_total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

$(window).keydown(function(e){
    if (e.which == 13) {
        var $targ = $(e.target);
        if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
            var focusNext = false;
            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                if (this === e.target) {
                    focusNext = true;
                }
                else if (focusNext){
                    $(this).focus();
                    return false;
                }
            });
            return false;
        }
    }
});

$('#purchase-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }
});
</script>
@endsection