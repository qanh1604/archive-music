@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="mb-0 h6">{{ 'Thêm quà cho phiên chợ' }}</h5>
</div>
<div class="">
    <form class="form form-horizontal mar-top" action="{{route('market-session.post-add-gift-market')}}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-12">
                <input name="_method" type="hidden" value="POST">
                <input type="hidden" name="id" value="{{$marketDetail->id}}">
                <input type="hidden" name="lang" value="{{ $lang }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Quà và số lượng</label>
                            <div class="market-gift">
                                <input type="hidden" name="types[]" value="sender_name">
                                <input type="hidden" name="types[]" value="gift_images">
                                <input type="hidden" name="types[]" value="gift_names">
                                <input type="hidden" name="types[]" value="gift_amounts">
                                @if ($marketDetail->gift != null)
                                    @foreach (json_decode($marketDetail->gift, true) as $key => $value)
                                        <div class="row gutters-5">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <input type="hidden" name="types[]" value="sender_name">
                                                    @if(isset($value['sender']))
                                                        <input type="text" class="form-control" placeholder="Tên người tặng" name="sender_name[]" value="{{ $value['sender'] }}" required>
                                                    @else
                                                        <input type="text" class="form-control" placeholder="Tên người tặng" name="sender_name[]" value="" required>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <input type="hidden" name="types[]" value="gift_names">
                                                    <input type="text" class="form-control" placeholder="Tên quà tặng" name="gift_names[]" value="{{ $value['name'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <input type="hidden" name="types[]" value="gift_amounts">
                                                    <input type="number" class="form-control" placeholder="Số lượng" name="gift_amounts[]" value="{{ $value['amount'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                                        </div>
                                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                        <input type="hidden" name="types[]" value="gift_images">
                                                        <input type="hidden" name="gift_images[]" class="selected-files" value="{{ $value['image'] }}" required>
                                                    </div>
                                                    <div class="file-preview box sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                        <i class="las la-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button
                                type="button"
                                class="btn btn-soft-secondary btn-sm"
                                data-toggle="add-more"
                                data-content='
                                    <div class="row gutters-5">
                                        <div class="col-md">
                                                <div class="form-group">
                                                    <input type="hidden" name="types[]" value="sender_name">
                                                    <input type="text" class="form-control" placeholder="Tên người tặng" name="sender_name[]" value="" required>
                                                </div>
                                            </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <input type="hidden" name="types[]" value="gift_names">
                                                <input type="text" class="form-control" placeholder="Tên quà tặng" name="gift_names[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <input type="hidden" name="types[]" value="gift_amounts">
                                                <input type="number" class="form-control" placeholder="Số lượng" name="gift_amounts[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate("Browse")}}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate("Choose File") }}</div>
                                                    <input type="hidden" name="types[]" value="gift_images">
                                                    <input type="hidden" name="gift_images[]" class="selected-files" value="" required>
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto">
                                            <div class="form-group">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                '
                                data-target=".market-gift">
                                {{ translate('Add New') }}
                            </button>
                            <button type="submit" class="btn btn-primary btn-update-give">{{ translate('Update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script type="text/javascript">
   $(document).ready(function(){
        
   });

</script>

@endsection
