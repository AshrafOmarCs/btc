@extends('layout2')
@section('content')
@section('title', 'Salary Paid')

 <!-- Row start -->

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="container">
                    @include('pages.messages2')

                    <form method="post" enctype="multipart/form-data" action="{{ url('/SalaryPaidSaveShe') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <table class="table border-borderless">
                                <tr>
                                    <th colspan="6">Import <b>Salary Paid</b> Excel File</th>
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
                                    <TH>#</TH>
                                    <TH>Paid Amount</TH>
                                    <TH>Iqama</TH>
                                    <TH>Account Number</TH>
                                    <TH>Journal Date</TH>
                                    <TH>Company</TH>
                                    <TH>warehouse</TH>
                                    <TH>EMP ID</TH>
                                    <TH>Driver</TH>
                                    <TH>Paid</TH>
                                    <TH>Salary Amount</TH>


                                </tr>

                                </thead>
                                <?php
                                $co = 0;
                                ?>
                                @foreach($Paid_DB as $Paid_db)
                                    <tr>
                                        <?php
                                        $co++;
                                        $row = explode(";", $Paid_db->AMP_ID);
                                        $rowspan = count($row);
                                        ?>
                                        <td rowspan="{{$rowspan}}">{{$co}}</td>
                                        <td rowspan="{{$rowspan}}">{{$Paid_db->bank_sum}}</td>
                                        <td rowspan="{{$rowspan}}">{{$Paid_db->account_owner_iqama}}</td>
                                        <td rowspan="{{$rowspan}}">{{$Paid_db->accountNumber}}</td>
                                        <?php
                                        echo "<td>" . explode(";", $Paid_db->journal_date)[0] . "</td>
                                                <td>" . explode(";", $Paid_db->companyName)[0] . "</td>
                                                <td>" . explode(";", $Paid_db->warehouseName)[0] . "</td>
                                                <td>" . explode(";", $Paid_db->AMP_ID)[0] . "</td>
                                                <td>" . explode(";", $Paid_db->fullName)[0] . "</td>
                                                <td style='text-align: center'>";
                                        if (explode(";", $Paid_db->paid)[0] == "1")
                                            echo "<span class='label label-success'>Yes</span>";
                                        else
                                            echo "<span class='label label-danger'>No</span>";
                                        echo "</td><td>" . explode(";", $Paid_db->salary_amount)[0] . "</td>";
                                        ?>
                                    </tr>
                                    <?php
                                    $td = explode(";", $Paid_db->journal_date);
                                    for ($i = 1; $i < count($td); $i++) {
                                        echo "<tr><td>" . explode(";", $Paid_db->journal_date)[$i] . "</td>
                                                    <td>" . explode(";", $Paid_db->companyName)[$i] . "</td>
                                                    <td>" . explode(";", $Paid_db->warehouseName)[$i] . "</td>
                                                    <td>" . explode(";", $Paid_db->AMP_ID)[$i] . "</td>
                                                    <td>" . explode(";", $Paid_db->fullName)[$i] . "</td>
                                                    <td style='text-align: center'>";
                                        if (explode(";", $Paid_db->paid)[$i] == "1")
                                            echo "<span class='label label-success'>Yes</span>";
                                        else
                                            echo "<span class='label label-danger'>No</span>";
                                        echo "</td><td>" . explode(";", $Paid_db->salary_amount)[$i] . "</td>

                                              </tr>";
                                    }
                                    ?>
                                @endforeach

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
