@extends('backend.layouts.appIframe')

@section('content')
@if(env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
    <div class="">
        <div class="alert alert-danger d-flex align-items-center">
            {{translate('Please Configure SMTP Setting to work all email sending functionality')}},
            <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
        </div>
    </div>
@endif

<div class="card general-statistic">
    <div class="card-header">
        <h6 class="mb-0">THỐNG KÊ TỔNG QUAN</h6>
    </div>
    <div class="card-body">
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ static_asset('assets/img/phien-giao-dich.svg') }}">
            <div class="d-flex flex-column ml-3">
                <span class="title">{{numberWithSymbol($totalSession)}}</span>
                <span class="sub_title">Phiên giao dịch</span>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ static_asset('assets/img/khach-hang.svg') }}">
            <div class="d-flex flex-column ml-3">
                <span class="title">{{numberWithSymbol($totalCustomer)}}</span>
                <span class="sub_title">Khách hàng</span>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ static_asset('assets/img/san-pham.svg') }}">
            <div class="d-flex flex-column ml-3">
                <span class="title">{{numberWithSymbol($totalProduct)}}</span>
                <span class="sub_title">Sản phẩm</span>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ static_asset('assets/img/doanh-thu.svg') }}">
            <div class="d-flex flex-column ml-3">
                <span class="title">{{numberWithSymbol($totalRevenue)}}</span>
                <span class="sub_title">Doanh thu</span>
            </div>
        </div>
    </div>
</div>
<div id="statistic_cfdn">
    <div class="card card-with-background">
        <div class="card-header mb-3 card-header-with-background" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link card-collapse-button" data-toggle="collapse" data-target="#collapseCFDN" aria-expanded="true" aria-controls="collapseCFDN">
                    <span class="accicon mr-1"><i class="las la-chevron-down rotate-icon"></i></span>Thống kê CFDN
                </button>
            </h5>
        </div>

        <div id="collapseCFDN" class="collapse show" aria-labelledby="headingOne" data-parent="#statistic_cfdn">
            <div class="row gutters-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Đơn hàng mua gói</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_package" 
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                    data-group="admin"
                                    data-name="package"
                                >
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-package" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Doanh thu từ gói thành viên/quầy hàng</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_revenue" 
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                    data-group="admin"
                                    data-name="revenue"
                                >
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-revenue" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col">
                                <h6 class="mb-0">Gói bán chạy</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($topSellPackage as $topSell)
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($topSell->file_name)
                                            <img class="statistic-image" src="/public/{{ $topSell->file_name }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/san-pham-2.svg') }}';">
                                        @else
                                            <img class="statistic-image" src="{{ static_asset('assets/img/san-pham-2.svg') }}">
                                        @endif 
                                    </div>
                                    <div class="col d-flex flex-column">
                                        <strong>{{ $topSell->name }}</strong>
                                        <!-- <span>Gói thành viên</span> -->
                                    </div>
                                    <div class="col-md-3 statistic-number">
                                        {{ $topSell->total }}
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col">
                                <h6 class="mb-0">Thương hiệu được quan tâm</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($topSellBrand as $topSell)
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($topSell->file_name)
                                            <img class="statistic-image" src="/public/{{ $topSell->file_name }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/san-pham-2.svg') }}';">
                                        @else
                                            <img class="statistic-image" src="{{ static_asset('assets/img/san-pham-2.svg') }}">
                                        @endif   
                                    </div>
                                    <div class="col d-flex flex-column">
                                        <strong>{{ $topSell->name }}</strong>
                                        <!-- <span>Gói thành viên</span> -->
                                    </div>
                                    <div class="col-md-3 statistic-number">
                                        {{ $topSell->total }}
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col">
                                <h6 class="mb-0">Ngành hàng được quan tâm</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($topSellCategory as $topSell)
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($topSell->file_name)
                                            <img class="statistic-image" src="/public/{{ $topSell->file_name }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/san-pham-2.svg') }}';">
                                        @else
                                            <img class="statistic-image" src="{{ static_asset('assets/img/san-pham-2.svg') }}">
                                        @endif     
                                    </div>
                                    <div class="col d-flex flex-column">
                                        <strong>{{ $topSell->name }}</strong>
                                        <!-- <span>Gói thành viên</span> -->
                                    </div>
                                    <div class="col-md-3 statistic-number">
                                        {{ $topSell->total }}
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="statistic_seller">
    <div class="card card-with-background">
        <div class="card-header mb-3 card-header-with-background" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link card-collapse-button" data-toggle="collapse" data-target="#collapseSeller" aria-expanded="true" aria-controls="collapseSeller">
                    <span class="accicon mr-1"><i class="las la-chevron-down rotate-icon"></i></span>Thống kê Quầy hàng
                </button>
            </h5>
        </div>

        <div id="collapseSeller" class="collapse show" aria-labelledby="headingOne" data-parent="#statistic_seller">
            <div class="row gutters-5">
                <div class="col-md-12">
                    <div class="aiz-titlebar text-left mt-2 mb-3">
                        <div class="col-md-12 mb-2">
                            <h5 class="mb-0 h6">Quầy hàng</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control aiz-selectpicker" data-name="select_value" data-group="seller" data-chart="chart" name="select_seller" id="select_seller" data-live-search="true">
                                <option value=""></option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->user_id }}">{{ $seller->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Đơn hàng</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_seller_package" 
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    data-group="seller"
                                    data-chart="chart"
                                    data-name="date_package"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                >
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 240px; height: auto">
                            <canvas id="chart-seller-package" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Doanh thu</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_seller_revenue" 
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    data-group="seller"
                                    data-chart="chart"
                                    data-name="date_revenue"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                >
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 240px; height: auto">
                            <canvas id="chart-seller-revenue" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col">
                                <h6 class="mb-0">Sản phẩm bán chạy</h6>
                            </div>
                        </div>
                        <div class="card-body" id="top_product">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="statistic_market">
    <div class="card card-with-background">
        <div class="card-header mb-3 card-header-with-background" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link card-collapse-button" data-toggle="collapse" data-target="#collapseMarket" aria-expanded="true" aria-controls="collapseMarket">
                    <span class="accicon mr-1"><i class="las la-chevron-down rotate-icon"></i></span>Thống kê Phiên giao dịch
                </button>
            </h5>
        </div>

        <div id="collapseMarket" class="collapse show" aria-labelledby="headingOne" data-parent="#statistic_market">
            <div class="row gutters-5">
                <div class="col-md-12">
                    <div class="aiz-titlebar text-left mt-2 mb-3">
                        <div class="col-md-12 mb-2">
                            <h5 class="mb-0 h6">Phiên giao dịch</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control aiz-selectpicker" data-name="select_value" data-group="market" data-chart="chart" name="select_market" id="select_market" data-live-search="true">
                                <option value=""></option>
                                @foreach($marketSessions as $session)
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
                                    <option value="{{ $session->id }}">
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
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Đơn hàng</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_market_package" 
                                    data-group="market"
                                    data-chart="chart"
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    data-name="date_package"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                >
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 240px; height: auto">
                            <canvas id="chart-market-package" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Biểu đồ Doanh thu</h6>
                            </div>
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control aiz-date-range input-border-none" 
                                    style="color: #7367F0" 
                                    id="date_range_market_revenue" 
                                    data-group="market"
                                    data-chart="chart"
                                    data-format="DD/MM/Y" 
                                    data-separator=" - " 
                                    autocomplete="off"
                                    data-name="date_revenue"
                                    value=" {{ date('01/m/Y') }} - {{ date('t/m/Y') }} "
                                >
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 240px; height: auto">
                            <canvas id="chart-market-revenue" class="w-100" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    var chartValue = '{!! $chartData !!}';
    var jsonChartValue = JSON.parse(chartValue);

    var chartConfig = {
        options: {
            legend: {
                labels: {
                    fontFamily: 'Montserrat',
                    boxWidth: 10,
                    usePointStyle: true,
                },
                onClick: function () {
                    return '';
                },
                position: 'bottom'
            }
        }
    }

    var adminChartPackage = new Chart($('#chart-package'),{
        type: 'line',
        data: {
            labels: Object.values(jsonChartValue.admin_package.labels),
            datasets: [
                {
                    label: 'Hủy',
                    data: Object.values(jsonChartValue.admin_package.data[0]),
                    borderColor: '#F46A6A',
                    backgroundColor: '#F46A6A', 
                },
                {
                    label: 'Hoàn thành',
                    data: Object.values(jsonChartValue.admin_package.data[1]),
                    borderColor: '#28C76F',
                    backgroundColor: '#28C76F', 
                }
            ]
        },
        ...chartConfig,
    });

    var adminChartRevenue = new Chart($('#chart-revenue'),{
        type: 'line',
        data: {
            labels: Object.values(jsonChartValue.revenue.labels),
            datasets: [
                {
                    label: 'Doanh thu từ gói thành viên/quầy hàng',
                    data: Object.values(jsonChartValue.revenue.data),
                    borderColor: '#FF5A00',
                    backgroundColor: '#FF5A00', 
                }
            ]
        },
        ...chartConfig,
    });

    var initPackageChart = {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Hủy',
                    data: [],
                    borderColor: '#F46A6A',
                    backgroundColor: '#F46A6A', 
                },
                {
                    label: 'Hoàn thành',
                    data: [],
                    borderColor: '#28C76F',
                    backgroundColor: '#28C76F', 
                }
            ]
        },
        ...chartConfig,
    };

    var initRevenueChart = {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Doanh thu từ gói thành viên/quầy hàng',
                    data: [],
                    borderColor: '#FF5A00',
                    backgroundColor: '#FF5A00', 
                }
            ]
        },
        ...chartConfig
    }

    var sellerChartPackage = new Chart($('#chart-seller-package'), initPackageChart);
    var sellerChartRevenue = new Chart($('#chart-seller-revenue'), initRevenueChart);

    var marketChartPackage = new Chart($('#chart-market-package'), initPackageChart);
    var marketChartRevenue = new Chart($('#chart-market-revenue'), initRevenueChart);

    $(document).ready(function(){
        $('[data-chart="chart"]').change(function(){
            getData($(this).attr('data-group'));
        });

        $('.aiz-date-range').on('apply.daterangepicker', function(){
            if($(this).attr('data-group') == 'admin'){
                getAdminChart($(this));
            }
            else{
                getData($(this).attr('data-group'));
            }
        });

        function getData(group){
            let data = {
                _token: "{{ csrf_token() }}",
                group: group
            };
            $(`[data-group="${group}"]`).each(function(){
                data[$(this).attr('data-name')] = $(this).val();
            });
            
            if(data.select_value){
                $.ajax({
                    url: '{{ route("admin.get-chart") }}',
                    method: 'POST',
                    data: data,
                    success: function(response){
                        initPackageChart.data.labels = response.data.package.labels;
                        initPackageChart.data.datasets[0].data = response.data.package.data.paid;
                        initPackageChart.data.datasets[1].data = response.data.package.data.unpaid;

                        initRevenueChart.data.labels = response.data.revenue.labels;
                        initRevenueChart.data.datasets[0].data = response.data.revenue.data;

                        if(group == 'seller'){
                            sellerChartPackage.destroy();
                            sellerChartRevenue.destroy();

                            sellerChartPackage = new Chart($('#chart-seller-package'), initPackageChart);
                            sellerChartRevenue = new Chart($('#chart-seller-revenue'), initRevenueChart);

                            if(response.data.top_product){
                                let topProduct = response.data.top_product;
                                let append = ``;
                                let tmpAppend = ``;

                                let i,j,temporary = [], chunk = 3;

                                for (i = 0,j = topProduct.length; i < j; i += chunk) {
                                    temporary = topProduct.slice(i, i + chunk);
                                    // do whatever
                                    
                                    temporary.map(value => {
                                        let img = ``;
                                        if(value.thumbnail_image){
                                            img = `<img class="statistic-image" src="/public/${value.thumbnail_image.file_name}" onerror="this.onerror=null;this.src='/public/assets/img/san-pham-2.svg';">`;
                                        }
                                        else{
                                            img = `<img class="statistic-image" src="/public/assets/img/san-pham-2.svg">`;
                                        }
                                        tmpAppend += `
                                            <div class="col-md-4">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        ${img}
                                                    </div>
                                                    <div class="col d-flex flex-column">
                                                        <strong>${value.name}</strong>
                                                        <span>${value.category.name}</span>
                                                    </div>
                                                    <div class="col-md-3 statistic-number">
                                                        ${value.num_of_sale}
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    });
                                    append += `<div class="row">` + tmpAppend + `</div><br>`;
                                    tmpAppend = ``;
                                } 
                                
                                
                                $('#top_product').html(append);
                            }
                        }
                        else if(group == 'market'){
                            marketChartPackage.destroy();
                            marketChartRevenue.destroy();
                            
                            marketChartPackage = new Chart($('#chart-market-package'), initPackageChart);
                            marketChartRevenue = new Chart($('#chart-market-revenue'), initRevenueChart);
                            $('#top_product').empty();
                        }
                    }
                });
            }
            else{
                initPackageChart.data.labels = [];
                initPackageChart.data.datasets[0].data = [];
                initPackageChart.data.datasets[1].data = [];

                initRevenueChart.data.labels = [];
                initRevenueChart.data.datasets[0].data = [];

                if(group == 'seller'){
                    new Chart($('#chart-seller-package'), initPackageChart);
                    new Chart($('#chart-seller-revenue'), initRevenueChart);
                }
                else if(group == 'market'){
                    new Chart($('#chart-market-package'), initPackageChart);
                    new Chart($('#chart-market-revenue'), initRevenueChart);
                }
            }
        }

        function getAdminChart(element){
            if(element.val()){
                let value = element.val();
                let $this = element;
                $.ajax({
                    url: '{{ route("admin.get-admin-chart") }}',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        date: value
                    },
                    success: function(response){
                        if($this.attr('data-name') == 'package'){
                            adminChartPackage.destroy();
                            adminChartPackage = new Chart($('#chart-package'),{
                                type: 'line',
                                data: {
                                    labels: Object.values(response.data.admin_package.labels),
                                    datasets: [
                                        {
                                            label: 'Hủy',
                                            data: Object.values(response.data.admin_package.data[0]),
                                            borderColor: '#F46A6A',
                                            backgroundColor: '#F46A6A', 
                                        },
                                        {
                                            label: 'Hoàn thành',
                                            data: Object.values(response.data.admin_package.data[1]),
                                            borderColor: '#28C76F',
                                            backgroundColor: '#28C76F', 
                                        }
                                    ]
                                },
                                ...chartConfig,
                            });
                        }
                        else if($this.attr('data-name') == 'revenue'){
                            adminChartRevenue.destroy();
                            adminChartRevenue = new Chart($('#chart-revenue'),{
                                type: 'line',
                                data: {
                                    labels: Object.values(response.data.revenue.labels),
                                    datasets: [
                                        {
                                            label: 'Doanh thu từ gói thành viên/quầy hàng',
                                            data: Object.values(response.data.revenue.data),
                                            borderColor: '#FF5A00',
                                            backgroundColor: '#FF5A00', 
                                        }
                                    ]
                                },
                                ...chartConfig,
                            });
                        }
                    }
                });
            }
        }
    });
</script>
@endsection
