<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-bordered aiz-table invoice-summary">
            <thead>
                <tr class="bg-trans-dark">
                    <th data-breakpoints="lg" class="min-col">#</th>
                    <th width="10%">{{translate('Photo')}}</th>
                    <th class="text-uppercase">{{translate('Description')}}</th>
                    <th data-breakpoints="lg" class="text-uppercase">{{translate('Delivery Type')}}</th>
                    <th data-breakpoints="lg" class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                    <th data-breakpoints="lg" class="min-col text-center text-uppercase">{{translate('Price')}}</th>
                    <th data-breakpoints="lg" class="min-col text-right text-uppercase">{{translate('Total')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $key => $orderDetail)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>
                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                            <a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                        @else
                            <strong>{{ translate('N/A') }}</strong>
                        @endif
                    </td>
                    <td>
                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                            <strong><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                            <small>{{ $orderDetail->variation }}</small>
                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                            <strong><a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank" class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                        @else
                            <strong>{{ translate('Product Unavailable') }}</strong>
                        @endif
                    </td>
                    <td>
                        @if ($order->shipping_type != null && $order->shipping_type == 'home_delivery')
                        {{ translate('Home Delivery') }}
                        @elseif ($order->shipping_type == 'pickup_point')

                        @if ($order->pickup_point != null)
                        {{ $order->pickup_point->getTranslation('name') }} ({{ translate('Pickup Point') }})
                        @else
                        {{ translate('Pickup Point') }}
                        @endif
                        @endif
                    </td>
                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                    <td class="text-center">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
                    <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix float-right">
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <strong class="text-muted">{{translate('Sub Total')}} :</strong>
                </td>
                <td>
                    {{ single_price($order->orderDetails->sum('price')) }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="text-muted">{{translate('Tax')}} :</strong>
                </td>
                <td>
                    {{ single_price($order->orderDetails->sum('tax')) }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="text-muted">{{translate('Shipping')}} :</strong>
                </td>
                <td>
                    {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="text-muted">{{translate('Coupon')}} :</strong>
                </td>
                <td>
                    {{ single_price($order->coupon_discount) }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="text-muted">{{translate('TOTAL')}} :</strong>
                </td>
                <td class="text-muted h5">
                    {{ single_price($order->grand_total) }}
                </td>
            </tr>
        </tbody>
    </table>
    {{-- <div class="text-right no-print">
        <a href="{{ route('invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
    </div> --}}
</div>