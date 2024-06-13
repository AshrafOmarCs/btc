@extends('layout2')
@section('content')
@section('title', 'Saned Paid')

 <!-- Row start -->

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="container">
                    @include('pages.messages2')

                    <form method="post" enctype="multipart/form-data" action="{{ url('/SANEDPaidSave') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <table class="table border-borderless">
                                <tr>
                                    <th colspan="6">Import <b>SANED Paid</b> Excel File</th>
                                </tr>
                                <tr>
                                    <td width="40%" align="right"><label>Select File for Upload .xls, .xslx</label></td>
                                    <td width="30">
                                        <input type="file" name="select_file" required/>
                                    </td>
                                    <td width="30%" align="left">
                                        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="card-title">

                </div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="loader" style="display:none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="" class="table">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Paid Amount</th>
                                    <th rowspan="2">Iqama</th>
                                    <th rowspan="2">Account Number</th>
                                    <th rowspan="2">SANED Date</th>
                                    <th rowspan="2">City</th>
                                    <th rowspan="2">EMP ID</th>
                                    <th rowspan="2">Driver</th>
                                    <th rowspan="2">Paid</th>
                                    <th rowspan="2">SANED Amount</th>
                                    <th rowspan="2">Bander Amount</th>
                                    <th rowspan="2">Bander Date</th>
                                    <th rowspan="2">Bander Commission</th>
                                    <th colspan="2" style="text-align: center; border-bottom: 0;">استلام</th>
                                    <th colspan="2" style="text-align: center; border-bottom: 0;">تسليم</th>
                                </tr>
                                <tr>
                                    <th>Bank</th>
                                    <th>Cash</th>
                                    <th>Bank</th>
                                    <th>Cash</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $co = 0;
                                ?>
                                @foreach($Paid_DB as $Paid_db)
                                    <?php
                                    $co++;
                                    $settledDates = explode(";", $Paid_db->SettledDate);
                                    $warehouseNames = explode(";", $Paid_db->warehouseName);
                                    $ampIds = explode(";", $Paid_db->AMP_ID);
                                    $fullNames = explode(";", $Paid_db->fullName);
                                    $driversJahizClearingPaidIds = explode(";", $Paid_db->drivers_jahiz_clearing_paid_id);
                                    $sanedAmounts = explode(";", $Paid_db->SANED_amount);
                                    $jahizAmounts = explode(";", $Paid_db->Jahiz_Amount);
                                    $updatedAts = explode(";", $Paid_db->updated_at);
                                    $banderCommissions = explode(";", $Paid_db->Bander_Commission);
                                    $bankPluses = explode(";", $Paid_db->bank_plus);
                                    $cashPluses = explode(";", $Paid_db->cash_plus);
                                    $bankMinuses = explode(";", $Paid_db->bank_minus);
                                    $cashMinuses = explode(";", $Paid_db->cash_minus);
                                    $rowspan = count($settledDates);
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle" rowspan="{{$rowspan}}">{{$co}}</td>
                                        <td style="vertical-align: middle" rowspan="{{$rowspan}}">{{$Paid_db->bank_minus_plus}}</td>
                                        <td style="vertical-align: middle" rowspan="{{$rowspan}}">{{$Paid_db->account_owner_iqama}}</td>
                                        <td style="vertical-align: middle" rowspan="{{$rowspan}}">{{$Paid_db->accountNumber}}</td>
                                        <td>{{ $settledDates[0] }}</td>
                                        <td>{{ $warehouseNames[0] }}</td>
                                        <td>{{ $ampIds[0] }}</td>
                                        <td>{{ $fullNames[0] }}</td>
                                        <td style='text-align: center'>
                                            @if (!empty($driversJahizClearingPaidIds[0]))
                                                <span class='badge badge-success'>Yes</span>
                                            @else
                                                <span class='badge badge-danger'>No</span>
                                            @endif
                                        </td>
                                        <td>{{ $sanedAmounts[0] }}</td>
                                        <td>{{ $jahizAmounts[0] }}</td>
                                        <td>{{ $updatedAts[0] }}</td>
                                        <td>{{ $banderCommissions[0] }}</td>
                                        <td>{{ $bankPluses[0] }}</td>
                                        <td>{{ $cashPluses[0] }}</td>
                                        <td>{{ $bankMinuses[0] }}</td>
                                        <td>{{ $cashMinuses[0] }}</td>
                                    </tr>
                                    @for ($i = 1; $i < $rowspan; $i++)
                                        <tr>
                                            <td>{{ $settledDates[$i] }}</td>
                                            <td>{{ $warehouseNames[$i] }}</td>
                                            <td>{{ $ampIds[$i] }}</td>
                                            <td>{{ $fullNames[$i] }}</td>
                                            <td style='text-align: center'>
                                                @if (!empty($driversJahizClearingPaidIds[$i]))
                                                    <span class='badge badge-success'>Yes</span>
                                                @else
                                                    <span class='badge badge-danger'>No</span>
                                                @endif
                                            </td>
                                            <td>{{ $sanedAmounts[$i] }}</td>
                                            <td>{{ $jahizAmounts[$i] }}</td>
                                            <td>{{ $updatedAts[$i] }}</td>
                                            <td>{{ $banderCommissions[$i] }}</td>
                                            <td>{{ $bankPluses[$i] }}</td>
                                            <td>{{ $cashPluses[$i] }}</td>
                                            <td>{{ $bankMinuses[$i] }}</td>
                                            <td>{{ $cashMinuses[$i] }}</td>
                                        </tr>
                                    @endfor
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
                <!-- Card end -->
            </div>
        <!-- Card end -->
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            exportOptions: {
                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            }
                        }
                    ],
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                });
    </script>
@stop
@endsection
