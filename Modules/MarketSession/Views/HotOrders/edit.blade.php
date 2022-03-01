@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
    </div>
    <div class="card-body">
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
            </div>
            @php
                $delivery_status = $order->delivery_status;
                $payment_status = $order->payment_status;
            @endphp

            <div class="col-md-3 ml-auto">
                <label for="update_payment_status">{{translate('Payment Status')}}</label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                    <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{translate('Unpaid')}}</option>
                    <option value="paid" @if ($payment_status == 'paid') selected @endif>{{translate('Paid')}}</option>
                </select>
            </div>
            <div class="col-md-3 ml-auto">
                <label for="update_delivery_status">{{translate('Delivery Status')}}</label>
                @if($delivery_status != 'delivered' && $delivery_status != 'cancelled')
                    <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                        <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                        <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option>
                        <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>{{translate('On The Way')}}</option>
                        <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                        <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option>
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ $delivery_status }}" disabled>
                @endif
            </div>
            <div class="col-md-3 ml-auto">
                <label for="update_tracking_code">{{translate('Tracking Code (optional)')}}</label>
                <input type="text" class="form-control" id="update_tracking_code" value="{{ $order->tracking_code }}">
            </div>
        </div>
        <div class="mb-3">
            <?php
                $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
            ?>
            {!! str_replace($removedXML,"", QrCode::size(100)->generate($order->order_code)) !!}
        </div>
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
                <address>
                    <strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                    {{ json_decode($order->shipping_address)->email }}<br>
                    {{ json_decode($order->shipping_address)->phone }}<br>
                    {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->state }}<br>
                    {{ json_decode($order->shipping_address)->country }}
                </address>
                @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                <br>
                <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }}, {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount) }}, {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                <br>
                <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank"><img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt="" height="100"></a>
                @endif
            </div>
            <div class="col-md-4 ml-auto">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order #')}}</td>
                            <td class="text-right text-info text-bold">	{{ $order->order_code }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order Status')}}</td>
                            <td class="text-right">
                                @if($delivery_status == 'delivered')
                                <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @else
                                <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order Date')}}	</td>
                            <td class="text-right">{{ date('d-m-Y h:i A', strtotime($order->order_at)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{translate('Total amount')}}
                            </td>
                            <td class="text-right">
                                {{ single_price($order->grand_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Payment method')}}</td>
                            <td class="text-right">{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="new-section-sm bord-no">
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
                <address>
                    <strong class="text-main">Đơn hàng mua nóng</strong><br>
                    {{ $order->product_name }}
                </address>
                <div class="row">
                    <div class="col-md-5">
                        <label for="update_payment_status">Chọn sản phẩm</label>
                        <select class="form-control aiz-selectpicker" data-live-search="true" id="list_products">
                            <option value="">Chọn sản phẩm</option>
                            @foreach($sellerProducts as $sellerProduct)
                                <option value="{{$sellerProduct->id}}">{{$sellerProduct->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="product_quantity">Chọn số lượng</label>
                        <input type="number" class="form-control" id="product_quantity" onchange="checkInStock()" placeholder="Số lượng" value="1">
                    </div>
                </div>
                <div id="variant_container" class="mt-3">
                    
                </div>
            </div>
        </div>
        <hr class="new-section-sm bord-no">
        <div id="product_detail_table">
            @include('MarketSession::HotOrders.inc.product_detail')
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('hot-order.update_delivery_status') }}', {
                _token:'{{ @csrf_token() }}',
                order_id:order_id,
                status:status
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });

        $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('hot-order.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });

        $('#update_tracking_code').on('change', function(){
            var order_id = {{ $order->id }};
            var tracking_code = $('#update_tracking_code').val();
            $.post('{{ route('hot-order.update_tracking_code') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,tracking_code:tracking_code}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Order tracking code has been updated') }}');
            });
        });

        $('#list_products').on('change', function(){
            $('#product_quantity').val(1);
            let value = $(this).val();
            if(!value){
                return;
            }

            $('#variant_container').html(
                `<div class="footable-loader">
                    <span class="fooicon fooicon-loader"></span>
                </div>
            `);
            $.get('/admin/hot-order/product_variant/'+value, function(data){
                let objectKeys = Object.keys(data.data);
                let variantContainer = ``;
                for(let i=0; i<objectKeys.length; i++){
                    let key = objectKeys[i];
                    if(key == 'colors'){
                        let colors = ``;
                        data.data.colors.value.map((value, index) => {
                            colors += `
                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="${value.name}" data-original-title="" title="">
                                    <input type="radio" onchange="checkInStock()" class="variants" name="color" value="${value.name}" ${index==0?'checked':''}>
                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                        <span class="size-30px d-inline-block rounded" style="background: ${value.code};"></span>
                                    </span>
                                </label>
                            `;
                        });
                        variantContainer += `
                            <div class="row no-gutters">
                                <div class="col-sm-2">
                                    <div class="opacity-50 my-2">${data.data.colors.translate}:</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-radio-inline">
                                        ${colors}
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    else{
                        let attr = ``;
                        data.data[key].value.map((value, index) => {
                            attr += `
                                <label class="aiz-megabox pl-0 mr-2">
                                    <input type="radio" onchange="checkInStock()" class="variants" name="attribute_id_${data.data[key].attribute_id}" value="${value}" ${index==0?'checked':''}>
                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                        ${value}
                                    </span>
                                </label>
                            `;
                        });

                        variantContainer += `
                            <div class="row no-gutters">
                                <div class="col-sm-2">
                                    <div class="opacity-50 my-2">${data.data[key].translate}:</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-radio-inline">
                                        ${attr}
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
                if(variantContainer){
                    variantContainer += `
                        <div class="row no-gutters">
                            <button class="btn btn-primary" id="add_product">Thêm sản phẩm</button>
                        </div>
                    `;
                }
                $('#variant_container').html(variantContainer);
                $('#add_product').addClass('d-none');
                checkInStock();
            });
        });

        $(document).on('click', '#add_product', function(e){
            let data = {
                product: $('#list_products').val(),
                quantity: $('#product_quantity').val(),
                order_id: "{{ $order->id }}",
                _token: '{{ @csrf_token() }}',
                variants: {}
            };
            $('.variants').each(function(){
                if($(this).prop('checked')){
                    data.variants[$(this).attr('name')] = $(this).val()
                }
            });

            $.post('{{ route('hot-order.add_product') }}', data, function(resData){
                if(resData.error){
                    AIZ.plugins.notify('warning', resData.error);
                }
                else{
                    AIZ.plugins.notify('success', 'Thêm sản phẩm thành công');
                    $('#product_detail_table').html(resData);
                    AIZ.plugins.fooTable();
                }
            });
        });

        function checkInStock(){
            let data = {
                id: $('#list_products').val(),
                quantity: $('#product_quantity').val(),
                order_id: "{{ $order->id }}",
                _token: '{{ @csrf_token() }}'
            };
            $('.variants').each(function(){
                if($(this).prop('checked')){
                    data[$(this).attr('name')] = $(this).val()
                }
            });
            $.ajax({
                type:"POST",
                url: '{{ route('products.variant_price') }}',
                data: data,
                success: function(data){
                    if(parseInt(data.in_stock) == 0 && data.digital  == 0){
                        $('#add_product').addClass('d-none');
                    }
                    else{
                        $('#add_product').removeClass('d-none');
                    }
                }
            });
        }
    </script>
@endsection
