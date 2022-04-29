@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Chỉnh sửa thông tin điều lệ')}}</h5>
</div>

<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Thông tin điều lệ')}}</h5>
        </div>

        <div class="card-body">
          <form action="{{route('charter_information.saveEdit', $information->id)}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-1 col-from-label" for="title">{{translate('Title')}}</label>
                    <div class="col-sm-11">
                        <input type="text" placeholder="{{translate('Title')}}" id="title" name="title" class="form-control" value="{{ $information->title }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1 col-from-label" for="content">{{translate('Content')}}</label>
                    <div class="col-sm-11">
                        {{-- @php
                            $metaDescription = '';
                            if($seller->user && $seller->user->shop){
                                $metaDescription = $seller->user->shop->meta_description;
                            }
                        @endphp
                        --}}
                        <textarea class="form-control description-form content-editor" placeholder="{{translate('Content')}}" id="content" name="content">{{ $information->content }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label" for="shopBackground">Image</label>
                    <div class="col-md-11">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="image" class="selected-files" value="{{ $information->image }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


