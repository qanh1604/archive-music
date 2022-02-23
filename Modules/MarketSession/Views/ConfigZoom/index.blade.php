@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">Zoom API KEY</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">API Key</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="zoom_api_key">
                                <input type="text" name="zoom_api_key" class="form-control" value="{{ get_setting('zoom_api_key') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">API Secret</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="zoom_api_secret">
                                <input type="text" name="zoom_api_secret" class="form-control" value="{{ get_setting('zoom_api_secret') }}">
                            </div>
                        </div>
                        <div class="text-right">
    						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    					</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
