<div id="seller-body" class="card-body">
    <table class="table aiz-table mb-0">
        <thead>
        <tr>
            <!--<th data-breakpoints="lg">#</th>-->
            <th>
                <div class="form-group">
                    <div class="aiz-checkbox-inline">
                        <label class="aiz-checkbox">
                            <input type="checkbox" class="check-all">
                            <span class="aiz-square-check"></span>
                        </label>
                    </div>
                </div>
            </th>
            <th>{{translate('Name')}}</th>
            <th data-breakpoints="lg">{{translate('Phone')}}</th>
            <th data-breakpoints="lg">{{translate('Email Address')}}</th>
            <th data-breakpoints="lg">{{translate('Verification Info')}}</th>
            <th data-breakpoints="lg">{{translate('Approval')}}</th>
            <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
            {{-- <th data-breakpoints="lg">{{ translate('Due to seller') }}</th> --}}
            <th data-breakpoints="lg">Ngành hàng</th>
            <th width="10%">{{translate('Options')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sellers as $key => $seller)
            @if($seller->user != null && $seller->user->shop != null)
                <tr>
                    <!--<td>{{ ($key+1) + ($sellers->currentPage() - 1)*$sellers->perPage() }}</td>-->
                    <td>
                        <div class="form-group">
                            <div class="aiz-checkbox-inline">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" class="check-one" name="id[]" value="{{$seller->id}}">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>@if($seller->user->banned == 1) <i class="fa fa-ban text-danger" aria-hidden="true"></i> @endif {{$seller->user->shop->name}}</td>
                    <td>{{$seller->user->phone}}</td>
                    <td>{{$seller->user->email}}</td>
                    <td>
                        @if ($seller->verification_info != null)
                            <a href="{{ route('sellers.show_verification_request', $seller->id) }}">
                                <span class="badge badge-inline badge-info">{{translate('Show')}}</span>
                            </a>
                        @endif
                    </td>
                    <td>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input onchange="update_approved(this)" value="{{ $seller->id }}" type="checkbox" <?php if($seller->verification_status == 1) echo "checked";?> >
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>{{ \App\Models\Product::where('user_id', $seller->user->id)->count() }}</td>
                    {{-- <td>
                        @if ($seller->admin_to_pay >= 0)
                            {{ single_price($seller->admin_to_pay) }}
                        @else
                            {{ single_price(abs($seller->admin_to_pay)) }} (Due to Admin)
                        @endif
                    </td> --}}
                    <td>{{ $seller->category }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="las la-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                {{-- <a href="#" onclick="show_seller_profile('{{$seller->id}}');"  class="dropdown-item">
                                    {{translate('Profile')}}
                                </a>
                                <a href="{{route('sellers.login', encrypt($seller->id))}}" class="dropdown-item">
                                    {{translate('Log in as this Seller')}}
                                </a>
                                <a href="#" onclick="show_seller_payment_modal('{{$seller->id}}');" class="dropdown-item">
                                    {{translate('Go to Payment')}}
                                </a>
                                <a href="{{route('sellers.payment_history', encrypt($seller->id))}}" class="dropdown-item">
                                    {{translate('Payment History')}}
                                </a> --}}
                                <a href="{{route('sellers.edit', encrypt($seller->id))}}" class="dropdown-item">
                                    {{translate('Edit')}}
                                </a>
                                @if($seller->user->banned != 1)
                                    <a href="#" onclick="confirm_ban('{{route('sellers.ban', $seller->id)}}');" class="dropdown-item">
                                    {{translate('Ban this seller')}}
                                    <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a href="#" onclick="confirm_unban('{{route('sellers.ban', $seller->id)}}');" class="dropdown-item">
                                    {{translate('Unban this seller')}}
                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                    </a>
                                @endif
                                <a href="#" class="dropdown-item confirm-delete" data-href="{{route('sellers.destroy', $seller->id)}}" class="">
                                    {{translate('Delete')}}
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div class="aiz-pagination">
        {{ $sellers->appends(request()->input())->links() }}
    </div>
</div>