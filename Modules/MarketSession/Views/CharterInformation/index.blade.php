@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Thông tin điều lệ')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('charter_information.create') }}" class="btn btn-primary">
                <span>{{translate('Tạo mới điều lệ')}}</span>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>{{translate('Title')}}</th>
                    <th>{{translate('Content')}}</th>
                    <th data-breakpoints="lg">{{translate('Image')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($information as $key => $infor)
                    <tr>
                        <td>{{ $infor->title }}</td>
                        <td>{{ $infor->content }}</td>
                        <td>
                            @if($infor->image != null)
                                <img src="{{ uploaded_asset($infor->image) }}" alt="{{translate('Banner')}}" class="h-50px">
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('charter_information.edit', $infor->id) }}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('charter_information.delete', $infor->id) }}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection

