@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="mb-0 h6">{{ 'Chỉnh sửa phiên họp' }}</h5>
</div>
<div class="">
    <form class="form form-horizontal mar-top" action="{{route('market-session.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-8">
                <input name="_method" type="hidden" value="POST">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="lang" value="{{ $lang }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Tên phiên chợ </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name" placeholder="Tên Phiên chợ" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Loại phiên chợ</label>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker" name="type" id="type" data-live-search="true" required>
                                    <option value="">Chọn loại phiên chợ</option>
                                    <option value="single">1 lần</option>
                                    <option value="weekly">Lặp lại theo tuần</option>
                                    <option value="monthly">Lặp lại theo tháng</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Ngày diễn ra phiên chợ</label>
                            <div class="col-lg-8 input-group" id="period-container">
                                <input type="text" class="form-control aiz-date-range" data-single="true" name="period" placeholder="Ngày diễn ra" data-time-picker="true" data-format="DD/MM/Y HH:mm:ss" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">Ảnh phiên chợ <small>(290x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="thumbnail_img" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Đường dẫn tham gia </label>
                            <div class="input-group col-lg-8">
                                <input type="text" class="form-control" name="" placeholder="Đường dẫn tham gia" disabled>
                                <a class="btn btn-soft-info btn-sm d-flex align-items-center copy-button" style="height: 42px; margin-left: 10px;" href="#">
                                    <span class="fw-500 ml-1 mr-0 d-none d-md-block">Sao chép</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">{{translate('Published')}}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="status" value="1" checked>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 text-right">
                    <button type="submit" name="button" class="btn btn-info">Tạo phiên chợ</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script type="text/javascript">
   $(document).ready(function(){
        $('.copy-button').on('click', function(e){
            e.preventDefault();
        });

        $('#type').on('change', function(){
            if($(this).val() == 'weekly'){
                $('#period-container').empty();
                let weekDay = [
                    'Chủ Nhật', 'Thứ 2', 'Thứ 3', 
                    'Thứ 4', 'Thứ 5','Thứ 6', 'Thứ 7'
                ];
                let weekOption = ``;
                weekDay.map((value, index) => {
                    weekOption += `<option value="${index+1}">${value}</option>`;
                });
                $('#period-container').append(`
                    <select name="period[]" id="period" class="form-coltrol aiz-selectpicker" multiple data-live-search="true" required>
                        <option value="">Ngày diễn ra</option>
                        ${weekOption}
                    </select>
                    <input type="text" class="form-control aiz-time-picker" name="period_time" style="margin-left: 10px" required>
                `);
                AIZ.plugins.bootstrapSelect('refresh');
                AIZ.plugins.timePicker();
            }
            else if($(this).val() == 'monthly'){
                $('#period-container').empty();
                let monthDay = Array.from({length: 31}, (_, i) => i + 1);
                let monthOption = ``;
                monthDay.map((value, index) => {
                    monthOption += `<option value="${value}">${value}</option>`;
                });
                $('#period-container').append(`
                    <select name="period[]" id="period" class="form-coltrol aiz-selectpicker" data-live-search="true" required>
                        <option value="">Ngày diễn ra</option>
                        ${monthOption}
                    </select>
                    <input type="text" class="form-control aiz-time-picker" name="period_time" style="margin-left: 10px" required>
                `);
                AIZ.plugins.bootstrapSelect('refresh');
                AIZ.plugins.timePicker();
            }
            else{
                $('#period-container').empty();
                $('#period-container').append(`
                    <input 
                        type="text" 
                        class="form-control aiz-date-range" 
                        data-single="true" 
                        name="period" 
                        placeholder="Ngày diễn ra" 
                        data-time-picker="true" 
                        data-format="DD/MM/Y HH:mm:ss"
                        required
                    >
                `);
                AIZ.plugins.dateRange();
            }
        });
   });

   function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
    }
</script>

@endsection
