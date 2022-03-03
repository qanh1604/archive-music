@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">Danh sách phiên chợ</h1>
        </div>
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Danh sách phiên chợ</h5>
            </div>
            
            <div class="col-md-2 ml-auto">
                <input type="text" class="form-control aiz-date-range" value="{{$searchDate?date('d/m/Y', strtotime($searchDate)):''}}" autocomplete="off" data-single="true" name="start_date" placeholder="Chọn ngày diễn ra" data-time-picker="false" data-format="DD/MM/Y">
            </div>
        </div>
    
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <!-- <th>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th> -->
                        <!--<th data-breakpoints="lg">#</th>-->
                        <th>Ngày diễn ra</th>
                        <th data-breakpoints="sm">Tổng số quà</th>
                        <th data-breakpoints="sm" class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marketSessions as $key => $session)
                    <tr>
                        <!-- <td>
                            <div class="form-group d-inline-block">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" class="check-one" name="id[]" value="{{$session->id}}">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                        </td> -->
                        <td>
                            <div class="row gutters-5 w-200px w-md-300px mw-100">
                                <div class="col">
                                    @php 
                                        $arrayOfWeekDays = [
                                            'Thứ 2', 'Thứ 3', 'Thứ 4', 
                                            'Thứ 5', 'Thứ 6', 'Thứ 6', 'Chủ Nhật'
                                        ];
                                        $weekDay = $arrayOfWeekDays[date('N', strtotime($session->start_time))-1];
                                        $day = date('d', strtotime($session->start_time));
                                        $month = date('m', strtotime($session->start_time));
                                        $year = date('Y', strtotime($session->start_time));
                                        $hour = date('H:i:s', strtotime($session->start_time));
                                    @endphp
                                    <span class="text-muted text-truncate-2">
                                        {{
                                            $weekDay . ' - ' . 
                                            'ngày ' . $day . 
                                            ' tháng ' . $month . 
                                            ' năm ' . $year .
                                            ' - ' . $hour
                                        }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $session->total_gift }}</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('market-session.get-add-gift-market', ['id'=>$session->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Thêm quà') }}">
                                <i class="las la-gift"></i>
                            </a>
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('market-session.get-winning-prize', ['id'=>$session->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Danh sách quà đã trao') }}">
                                <i class="las la-clipboard"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $marketSessions->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<script type="text/javascript">
        
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_products(el){
            $('#sort_products').submit();
        }
        
        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('market-session.bulk-product-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

        $(document).on('click', '.copy-button', function(e){
            e.preventDefault();
            copyToClipboard($(this).attr('data-value'));
            AIZ.plugins.notify('success', 'Đã sao chép vào bộ nhớ tạm');
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
