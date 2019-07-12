@extends('layouts.master')
@section('style')
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel" id="app">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.dashboard')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-dashboard"></i> {{__('page.dashboard')}}</h4>
        </div>

        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="row row-sm">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.today_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['today_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['today_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-danger rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-truck tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.week_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['week_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['week_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-calendar tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.month_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['month_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['month_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-br-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.overall_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['overall_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['overall_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
            </div>
            <div class="row row-sm mt-3">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-sun-o tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.today_sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['today_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['today_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-danger rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('week.sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['week_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['week_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.month_sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['month_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['month_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-br-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.overall_sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['overall_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['overall_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
            </div>
            <div class="br-section-wrapper mt-3">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <h4 class="tx-primary float-left">{{__('page.overview')}}</h4>
                        <form action="" class="form-inline float-right" method="post">
                            @csrf
                            <input type="text" class="form-control input-sm" name="period" id="period" style="width:250px !important" value="{{$period}}" autocomplete="off" placeholder="{{__('page.period')}}">
                            <button type="submit" class="btn btn-primary pd-y-7 mg-l-10"> <i class="fa fa-search"></i> {{__('page.search')}}</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="card card-body">                        
                        <canvas id="line_chart" style="height:400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/chart.js/Chart.js')}}"></script>
<script src="{{asset('master/lib/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
<script>

    var lineData = {
        labels: {!! json_encode($key_array) !!},
        datasets: [
            {
                label: "{{__('page.purchase')}}",
                backgroundColor: 'rgba(52,152,219, 0.6)',
                borderColor: 'rgba(52,152,219, 1)',
                pointBorderColor: "#fff",
                data: {!! json_encode($purchase_array) !!},
            },{
                label: "{{__('page.sale')}}",
                backgroundColor: 'rgba(213,217,219, 0.6)',
                borderColor: 'rgba(213,217,219, 1)',
                pointBorderColor: "#fff",
                data: {!! json_encode($sale_array) !!},
            }
        ]
    };
    var lineOptions = {
        responsive: true,
        maintainAspectRatio: false,      
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false,
                    callback: function(value, index, values) {
                        return value.toLocaleString();
                    }
                }
            }]
        }
    };
    var ctx = document.getElementById("line_chart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

</script>
<script>
    $(document).ready(function () {
        $("#period").dateRangePicker()
    });
</script>
@endsection
