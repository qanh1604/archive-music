@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add New Seller')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <form action="{{ route('sellers.store') }}" method="POST">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Seller Information')}}</h5>
            </div>
            <div class="card-body">
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="email">{{translate('Email Address')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Email Address')}}" id="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="password">{{translate('Password')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{translate('Password')}}" id="password" name="password" class="form-control" required>
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
                            <input type="hidden" name="open_video_360" class="selected-files">
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
                            <input type="hidden" name="open_video_480" class="selected-files">
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
                            <input type="hidden" name="open_video_720" class="selected-files">
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
                            <input type="hidden" name="open_video_1080" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Shop information')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="shop_name">{{translate('Shop Name')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Shop Name')}}" id="shop_name" name="shop_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="address">{{translate('Address')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Address')}}" id="address" name="address" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}<span class="text-danger text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="meta_description">{{translate('Meta description')}}</label>
                    <div class="col-sm-9">
                    <textarea class="form-control" placeholder="{{translate('Meta description')}}" id="meta_description" name="meta_description"></textarea>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    $(document).on('ready.ft.table', function(){
        $('[data-toggle="aizuploader1"]').each(function () {
            $(this).attr('data-toggle', 'aizuploader');
        });
        AIZ.uploader.previewGenerate();
    });
</script>
@endsection
