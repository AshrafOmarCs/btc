@extends('AdminLTE')
@section('content')

    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Finance Unroll</h2>
        </div>
    </div>

        <div style=" clear: both;">
            <form action="{{ route('automation/approval')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ACTION" value="{{$type}}">

                <table id="customer_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <TH rowspan="2">Warehouse</TH>
                            <TH rowspan="2">Driver Name</TH>
                            <TH rowspan="2">Job Id</TH>
                            <TH rowspan="2">Registration</TH>
                            <TH rowspan="2">Note</TH>
                            <TH rowspan="2">Carried Down</TH>
                            <TH rowspan="2">Current Balance</TH>
                            <TH colspan="2" style="text-align: center">Finance</TH>
                        </tr>
                        <tr>
                            <TH>Credit</TH>
                            <TH>Debit</TH>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <TH rowspan="2">Warehouse</TH>
                            <TH rowspan="2">Driver Name</TH>
                            <TH rowspan="2">Job Id</TH>
                            <TH rowspan="2">Registration</TH>
                            <TH rowspan="2">Note</TH>
                            <TH rowspan="2">Carried Down</TH>
                            <TH rowspan="2">Current Balance</TH>
                            <TH>Credit</TH>
                            <TH>Debit</TH>
                        </tr>
                        <tr>
                            <TH colspan="2" style="text-align: center">Finance</TH>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($results as $result)
                            
                            <tr>
                                <td><input type="hidden" name="ids[]" value="{{$result->id}}">{{$result->warehouseName}}</td>
                                <td>{{$result->fullName}}</td>
                                <td>{{$result->job_id}}</td>
                                <td><button type="button" class="btn btn-success" style="border-radius: 20px; cursor: auto;">Registered</button></td>
                                <td>{{$result->note}}</td>
                                <td>{{$result->carried_down}}</td>
                                <td>{{$result->current_balance}}</td>
                                <td>{{$result->credit}}</td>
                                <td>{{$result->debit}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12" style="margin: 20px; direction: rtl ">
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </form>

        </div>

    <script>
        $('#customer_data').DataTable({
            order: [],
            // lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            bPaginate: false,
            bAutoWidth: false, 
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [ 4, 7 ]
                }
            ],
            responsive: true,
            processing: true,
        });
    </script>


@endsection
