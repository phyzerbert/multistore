@extends('layouts.master')
@section('style')

@endsection
@section('content')
    <div class="br-mainpanel" id="app">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Dashboard</h4>
        </div>

        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row"></div>
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
<script>

    var lineData = {
        labels: {!! json_encode($key_array) !!},
        datasets: [
            {
                label: "Purchase",
                backgroundColor: 'rgba(52,152,219, 0.6)',
                borderColor: 'rgba(52,152,219, 1)',
                pointBorderColor: "#fff",
                data: {!! json_encode($purchase_array) !!},
            },{
                label: "Sale",
                backgroundColor: 'rgba(213,217,219, 0.6)',
                borderColor: 'rgba(213,217,219, 1)',
                pointBorderColor: "#fff",
                data: {!! json_encode($sale_array) !!},
            }
        ]
    };
    var lineOptions = {
        responsive: true,
        maintainAspectRatio: false
    };
    var ctx = document.getElementById("line_chart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

</script>
<script>
    $(document).ready(function () {

    });
</script>
@endsection
