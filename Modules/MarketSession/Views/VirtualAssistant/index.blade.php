@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Thông tin trợ lý ảo')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('virtual_assistant.create') }}" class="btn btn-primary">
                <span>{{translate('Tạo mới trợ lý ảo')}}</span>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>{{translate('Seller')}}</th>
                    <th>{{translate('Description')}}</th>
                    <th data-breakpoints="lg">{{translate('Video')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($virtual_assistants as $key => $virtual_assistant)
                    <tr>
                        <td>{{ $virtual_assistant->seller?$virtual_assistant->seller->user->shop->name:"" }}</td>
                        <td>{{ $virtual_assistant->description }}</td>

                        <td>
                            <div class="input-group" data-toggle="aizuploader" data-type="video" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="video" value="{{ $virtual_assistant->video }}" id="video_{{ $virtual_assistant->id }}" class="selected-files video-virtual">
                            </div>
                            <div class="file-preview box sm"></div>
                        </td>
                        
                        <td class="text-right">
                            <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm save-virtual" data-href="{{ route('virtual_assistant.saveEdit', $virtual_assistant->id) }}" title="{{ translate('Save') }}">
                                <i class="las la-save"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('virtual_assistant.delete', $virtual_assistant->id) }}" title="{{ translate('Delete') }}">
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

@section('script')
    <style>
        .virtual_assistant .remove {
            display: none
        }
    </style>
    <script>
        $(document).ready(function(e){
            $(document).on('click', '.save-virtual', function(e) {
                e.preventDefault();
                var url = $('.save-virtual').attr('data-href');
                var video = $('.video-virtual').attr('value');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    data: {video},
                    type: 'POST',
                    success: function (response) {
                        AIZ.plugins.notify('success', 'Đã lưu thành công');
                    }
                });
            });
            
        });
    </script>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

