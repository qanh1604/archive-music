@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Tạo trợ lý ảo')}}</h5>
</div>

<div>
    <div class="card">
        <div class="card-body">
          <form action="{{route('virtual_assistant.save')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-md-1 col-form-label" for="shopBackground">Image</label>
                    <div class="col-md-11">
                        <div class="input-group" data-toggle="aizuploader" data-type="video">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="video" class="selected-files" value="">
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


