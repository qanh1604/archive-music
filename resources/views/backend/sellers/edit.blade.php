@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Edit Seller Information')}}</h5>
</div>

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Seller Information')}}</h5>
        </div>

        <div class="card-body">
          <form action="{{ route('sellers.update', $seller->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{$seller->user->name}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="email">{{translate('Email Address')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Email Address')}}" id="email" name="email" class="form-control" value="{{$seller->user->email}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="password">Password</label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{translate('Password')}}" id="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="meta_description">{{translate('Meta description')}}</label>
                    <div class="col-sm-9">
                        @php
                            $metaDescription = '';
                            if($seller->user && $seller->user->shop){
                                $metaDescription = $seller->user->shop->meta_description;
                            }
                        @endphp
                        <textarea class="form-control" placeholder="{{translate('Meta description')}}" id="meta_description" name="meta_description">{{ $metaDescription }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopBackground">Background quầy hàng</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="background_img" class="selected-files" value="{{ $seller->user->shop->background_img }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopOpenVideo">Video (480 x 360)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="open_video_360" value="{{ $open_video_360?$open_video_360:'' }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopOpenVideo">Video (858 x 480)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="open_video_480" value="{{ $open_video_480?$open_video_480:'' }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopOpenVideo">Video (1280 x 720)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="open_video_720" value="{{ $open_video_720?$open_video_720:'' }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopOpenVideo">Video (1920 x 1080)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="open_video_1080" value="{{ $open_video_1080?$open_video_1080:'' }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopVAssistant">Video trợ lý ảo (480 x 360)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            @if(isset($virtual_assistant))
                                <input type="hidden" name="virtual_assistant_360" class="selected-files" value="{{ $virtual_assistant_360 }}">
                            @else
                                <input type="hidden" name="virtual_assistant_360" class="selected-files" value="">
                            @endif
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopVAssistant">Video trợ lý ảo (858 x 480)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            @if(isset($virtual_assistant))
                                <input type="hidden" name="virtual_assistant_480" class="selected-files" value="{{ $virtual_assistant_480 }}">
                            @else
                                <input type="hidden" name="virtual_assistant_480" class="selected-files" value="">
                            @endif
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopVAssistant">Video trợ lý ảo (1280 x 720)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            @if(isset($virtual_assistant))
                                <input type="hidden" name="virtual_assistant_720" class="selected-files" value="{{ $virtual_assistant_720 }}">
                            @else
                                <input type="hidden" name="virtual_assistant_720" class="selected-files" value="">
                            @endif
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="shopVAssistant">Video trợ lý ảo (1920 x 1080)</label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            @if(isset($virtual_assistant))
                                <input type="hidden" name="virtual_assistant_1080" class="selected-files" value="{{ $virtual_assistant_1080 }}">
                            @else
                                <input type="hidden" name="virtual_assistant_1080" class="selected-files" value="">
                            @endif
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="description">Mô tả trợ lý</label>
                    <div class="col-sm-9">
                        @if(isset($virtual_assistant))
                            <input type="description" placeholder="{{translate('Mô tả')}}" id="description" name="description" value="{{ $virtual_assistant->description }}" class="form-control">
                        @else
                            <input type="description" placeholder="{{translate('Mô tả')}}" id="description" name="description" value="" class="form-control">
                        @endif
                        
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
