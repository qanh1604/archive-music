@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">Danh sách quà đã trao</h1>
        </div>
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Danh sách quà đã trao</h5>
            </div>
        </div>
    
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>Quà</th>
                        <th data-breakpoints="sm">Người dùng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($giftData as $gift)
                        @php
                            $user = \App\Models\User::find($gift['user']['id']);
                        @endphp
                        <tr>
                            <td>
                                <div class="row gutters-5 w-200px w-md-300px mw-100">
                                    @if( $gift['image'] )
                                        <div class="col-auto">
                                            <img src="{{ uploaded_asset($gift['image'])}}" alt="Image" class="size-50px img-fit">
                                        </div>
                                    @endif
                                    <div class="col">
                                        <span class="text-muted text-truncate-2">{{ $gift['name'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($perPage < $total)
                <div class="aiz-pagination">
                    {!! $links !!}
                </div>
            @endif
        </div>
    </form>
</div>

@endsection

@section('script')
@endsection
