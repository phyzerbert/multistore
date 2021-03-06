@extends('layouts.master')
@section('style')
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="#">{{__('page.reports')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.store_chart')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-bar-chart"></i> {{__('page.store_chart')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="" class="form-inline mx-auto" method="post">
                            @csrf
                            <input type="text" class="form-control form-control-sm" name="period" id="period" style="width:250px !important" value="{{$period}}" autocomplete="off" placeholder="{{__('page.period')}}">
                            <button type="submit" class="btn btn-primary pd-y-7 mg-l-10"> <i class="fa fa-search"></i> {{__('page.search')}}</button>
                            <button type="button" class="btn btn-warning pd-y-7 mg-l-10" id="btn-reset"> <i class="fa fa-eraser"></i> {{__('page.reset')}}</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="card card-body">
                        <canvas id="bar_chart" style="height:600px;"></canvas>
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
    var barData = {
        labels: {!! json_encode($store_names) !!},
        datasets: [
            {
                label: "{{__('page.purchase')}}",
                backgroundColor:'#DADDE0',
                data: {!! json_encode($store_purchases_array) !!}
            },
            {
                label: "{{__('page.sale')}}",
                backgroundColor: '#2ecc71',
                borderColor: "#fff",
                data: {!! json_encode($store_sales_array) !!}
            }
        ]
    };
    var barOptions = {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
            callbacks: {
                label: function(tooltipItems, data) {
                    let value = parseInt(data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index]).toLocaleString();
                    return data.datasets[tooltipItems.datasetIndex].label + ": " + value;
                }
            }
        },      
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

    var ctx = document.getElementById("bar_chart").getContext("2d");
    new Chart(ctx, {type: 'bar', data: barData, options:barOptions}); 
</script>

<script>
    $(document).ready(function () {
        $("#period").dateRangePicker()
        $("#btn-reset").click(function(){
            $("#period").val('');
        });
    });
</script>
@endsection
