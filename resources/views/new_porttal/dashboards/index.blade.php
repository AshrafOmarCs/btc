@extends('layout2')
@section('content')
 <!-- Row start -->
 <div class="row">
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-red">
                <i class="bi bi-pie-chart"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-red" style="font-size: 19px;">2,580,112.00 SAR</h3>
                <p>Sales in 1Q</p>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-blue">
                <i class="bi bi-emoji-smile"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-blue">7.1K</h3>
                <p>Drivers</p>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-yellow">227 </h3>
                <p>Vihcles</p>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-green">
                <i class="bi bi-handbag"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-green">48 </h3>
                <p>Employees & Supervisors</p>
            </div>
        </div>
    </div>
</div>
<!-- Row start -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Stacked Area</div>
            </div>
            <div class="card-body">
                <div id="basic-area-stack-graph"></div>
            </div>
        </div>
    </div> 
</div>
<!-- Row end -->

<div class="col-sm-6 col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Activity</div>
        </div>
        <div class="card-body">

            <div class="scroll370">
                <div class="activity-container">
                    <div class="activity-block">
                        <div class="activity-user">
                            <img src="assets/images/user.png" alt="Activity User">
                        </div>
                        <div class="activity-details">
                            <h4>Lilly Desmet</h4>
                            <h5>3 hours ago</h5>
                            <p>Sent invoice ref. #23457</p>
                            <span class="badge shade-green">Sent</span>
                        </div>
                    </div>
                    <div class="activity-block">
                        <div class="activity-user">
                            <img src="assets/images/user3.png" alt="Activity User">
                        </div>
                        <div class="activity-details">
                            <h4>Jennifer Wilson</h4>
                            <h5>7 hours ago</h5>
                            <p>Paid invoice ref. #23459</p>
                            <span class="badge shade-red">Payments</span>
                        </div>
                    </div>
                    <div class="activity-block">
                        <div class="activity-user">
                            <img src="assets/images/user4.png" alt="Activity User">
                        </div>
                        <div class="activity-details">
                            <h4>Elliott Hermans</h4>
                            <h5>1 day ago</h5>
                            <p>Paid invoice ref. #23473</p>
                            <span class="badge shade-green">Paid</span>
                        </div>
                    </div>
                    <div class="activity-block">
                        <div class="activity-user">
                            <img src="assets/images/user5.png" alt="Activity User">
                        </div>
                        <div class="activity-details">
                            <h4>Sophie Michiels</h4>
                            <h5>3 day ago</h5>
                            <p>Paid invoice ref. #26788</p>
                            <span class="badge shade-green">Sent</span>
                        </div>
                    </div>
                    <div class="activity-block">
                        <div class="activity-user">
                            <img src="assets/images/user2.png" alt="Activity User">
                        </div>
                        <div class="activity-details">
                            <h4>Ilyana Maes</h4>
                            <h5>One week ago</h5>
                            <p>Paid invoice ref. #34546</p>
                            <span class="badge shade-red">Invoice</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Apex Charts -->
@section('javascript') 
    <!-- Apex Charts -->
    <script src="{{asset('assets/vendor/apex/apexcharts.min.js')}}"></script> 
    <script src="{{asset('assets/vendor/apex/examples/area/basic-area-graph-stacked.js')}}"></script> 
@stop	 
@endsection