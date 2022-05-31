@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="mb-0 h6">Chi tiết phiên chợ</h5>
</div>
<div class="">
    <form class="form form-horizontal mar-top" action="{{route('market-session.update', $session->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-8">
                <input name="_method" type="hidden" value="POST">
                <input type="hidden" name="id" value="{{ $session->id }}">
                <input type="hidden" name="lang" value="{{ $lang }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Tên phiên chợ </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name" placeholder="Tên Phiên chợ" value="{{ $session->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Loại phiên chợ</label>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker" name="type" id="type" data-live-search="true" required>
                                    <option value="">Chọn loại phiên chợ</option>
                                    <option value="single" @if($session->type == 'single') selected @endif>1 lần</option>
                                    <option value="weekly" @if($session->type == 'weekly') selected @endif>Lặp lại theo tuần</option>
                                    <option value="monthly" @if($session->type == 'monthly') selected @endif>Lặp lại theo tháng</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Ngày diễn ra phiên chợ</label>
                            <div class="col-lg-8 input-group" id="period-container">
                                @if($session->type != 'single')
                                    <select name="period[]" id="period" class="form-coltrol aiz-selectpicker" @if($session->type=='weekly') multiple @endif data-live-search="true" required>
                                        <option value="">Ngày diễn ra</option>
                                        @php 
                                            $periodData = [];
                                            if($session->type == 'weekly'){
                                                $periodData = [
                                                    'Thứ 2', 'Thứ 3', 'Thứ 4', 
                                                    'Thứ 5','Thứ 6', 'Thứ 7', 'Chủ Nhật'
                                                ];
                                            }
                                            elseif($session->type == 'monthly'){
                                                $periodData = range(1,31);
                                            }
                                            $periodTime = $session->date_interval;
                                            $periodTime = explode(',', $periodTime);
                                        @endphp
                                        @foreach($periodData as $key => $value)
                                            <option value="{{$key+1}}" @if(in_array($key+1, $periodTime)) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control aiz-time-picker" autocomplete="off" name="period_time" style="margin-left: 10px" value="{{date('h:i:s', strtotime($session->start_date))}}" required>
                                @else
                                    <input type="text" class="form-control aiz-date-range" autocomplete="off" data-single="true" name="period" placeholder="Ngày diễn ra" data-time-picker="true" data-format="DD/MM/Y HH:mm:ss" value="{{date('d/m/Y H:i:s', strtotime($session->start_date))}}" required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Thời lượng (phút)</label>
                            <div class="col-lg-8 input-group" id="duration">
                                <input type="number" class="form-control" name="duration" autocomplete="off" placeholder="Thời lượng phiên chợ" value="{{$session->duration}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Ngày kết thúc phiên chợ</label>
                            <div class="col-lg-8 input-group" id="end_session_date">
                                <input type="text" class="form-control aiz-date-range" autocomplete="off" data-single="true" name="end_session_date" placeholder="Ngày kết thúc phiên chợ" data-time-picker="false" data-format="DD/MM/Y" required value="{{date('d/m/Y', strtotime($session->end_session_date))}}">
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
                                    <input type="hidden" name="thumbnail_img" value="{{ $session->image }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Đường dẫn tham gia </label>
                            <div class="input-group col-lg-8">
                                <input type="text" class="form-control" name="" placeholder="Đường dẫn tham gia" value="{{$session->join_link}}" disabled>
                                <a class="btn btn-soft-info btn-sm d-flex align-items-center copy-button" data-value="{{$session->join_link}}" style="height: 42px; margin-left: 10px;" href="#">
                                    <span class="fw-500 ml-1 mr-0 d-none d-md-block">Sao chép</span>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">Video mở đầu </label>
                            <div class="input-group col-lg-8" data-toggle="aizuploader1" data-type="video" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="slider_video" value="{{ $session->video_slider }}" id="slider_video_" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
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
                                            <input type="checkbox" name="status" value="1" @if($session->status == 1) checked @endif>
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
                    <!-- <button type="submit" name="button" class="btn btn-info">Cập nhật phiên chợ</button> -->
                </div>
            </div>
        </div>
    </form>

    <br>
    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">Danh sách người đăng ký</h5>
                </div>
                <div class="col-md-5 ml-auto">
                    <input type="hidden" value="{{ $lang }}" name="lang">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="session_id" name="session_id" onchange="sort_products()">
                        <option value="">Chọn phiên</option>
                        @foreach($marketSessionLists as $marketSession)
                            @php 
                                $arrayOfWeekDays = [
                                    'Thứ 2', 'Thứ 3', 'Thứ 4', 
                                    'Thứ 5', 'Thứ 6', 'Thứ 6', 'Chủ Nhật'
                                ];
                                $weekDay = $arrayOfWeekDays[date('N', strtotime($marketSession->start_time))-1];
                                $day = date('d', strtotime($marketSession->start_time));
                                $month = date('m', strtotime($marketSession->start_time));
                                $year = date('Y', strtotime($marketSession->start_time));
                                $hour = date('H:i:s', strtotime($marketSession->start_time));
                            @endphp
                            <option value="{{$marketSession->id}}" @if($sessionId == $marketSession->id) selected @endif>
                                {{
                                    $weekDay . ' - ' . 
                                    'ngày ' . $day . 
                                    ' tháng ' . $month . 
                                    ' năm ' . $year .
                                    ' - ' . $hour
                                }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>Tên quầy hàng</th>
                            <th data-breakpoints="sm">Loại</th>
                            <th data-breakpoints="sm">Thời điểm tham gia</th>
                            {{--<th data-breakpoints="lg">Video mở đầu</th>
                            <th data-breakpoints="lg">Video slider</th>--}}
                            <th data-breakpoints="lg"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $key => $seller)
                        <tr>
                            <td>
                                <div class="row gutters-5 w-200px w-md-300px mw-100">
                                    <div class="col">
                                        <span class="text-muted text-truncate-2">{{ $seller->joinerUser->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $seller->joinerUser->user_type=='seller' ? 'Quầy hàng' : 'Khách'}}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($seller->join_time)) }}</td>
                            {{--<td>
                                <div class="input-group" data-toggle="aizuploader1" data-type="video" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="slider_video" value="{{ $seller->slider_video }}" id="slider_video_{{ $seller->id }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </td>--}}
                            <td style="text-align: right"><button class="btn btn-sm btn-primary save-video" data-id="{{ $seller->id }}">{{ translate('Save') }} Video</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ !$sellers->isEmpty()?$sellers->appends(request()->input())->links():'' }}
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
   $(document).ready(function(){
        $('.copy-button').on('click', function(e){
            e.preventDefault();
            copyToClipboard($(this).attr('data-value'));
            AIZ.plugins.notify('success', 'Đã sao chép vào bộ nhớ tạm');
        });

        $('[data-toggle="aizuploader1"]').each(function () {
            $(this).attr('data-toggle', 'aizuploader');
        });
        AIZ.uploader.previewGenerate();

        $('#type').on('change', function(){
            if($(this).val() == 'weekly'){
                $('#period-container').empty();
                let weekDay = [
                    'Thứ 2', 'Thứ 3', 'Thứ 4', 
                    'Thứ 5','Thứ 6', 'Thứ 7', 'Chủ Nhật'
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
                    <input type="text" autocomplete="off" class="form-control aiz-time-picker" style="margin-left: 10px" name="period_time" required>
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
                    <input type="text" autocomplete="off" class="form-control aiz-time-picker" style="margin-left: 10px" name="period_time" required>
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
                        autocomplete="off"
                    >
                `);
                AIZ.plugins.dateRange();
            }
        });

        $(document).on('click', '.save-video', function(e){
            e.preventDefault();
            let sellerId = $(this).attr('data-id');
            $.post('{{ route("market-session.update_video") }}', {
                _token: "{{ csrf_token() }}",
                id: sellerId,
                open_video: $(`#open_video_${sellerId}`).val(),
                slider_video: $(`#slider_video_${sellerId}`).val(),
            }, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', 'Đã thêm video thành công');
                }
                else{
                    AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                }
            });
        });
   });

    function sort_products(el){
        $('#sort_products').submit();
    }

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
