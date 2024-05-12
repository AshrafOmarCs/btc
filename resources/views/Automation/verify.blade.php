@extends('AdminLTE')
@section('content')
@section('title', __('automation.verification'))

    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{__('automation.fin_operations')}}</h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
                
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="">
                    <tr>
                        <th style="padding: 15px !important;font-size: medium;">
                            {{__('automation.selected_model')}}: <p style="font-weight: 400;"> {{$model}} </p>
                        </th>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.operation_type')}}: <p style="font-weight: 400;">{{$operation_type}}</p>
                        </th>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.journal_date')}} <p style="font-weight: 400;">{{$journal_date}}</p>
                        </th>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.employee')}}: <p style="font-weight: 400;">{{Auth::user()->name}}</p>
                        </th>
                    </tr>
                    <tr>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.company')}}: <p style="font-weight: 400;">{{$company}}</p>
                        </th>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.total_amount')}}: <p style="font-weight: 400;">{{$amount}}</p>
                        </th>
                        <th style="padding: 15px !important; font-size: medium;">
                            {{__('automation.total_new_driver')}}: <p style="font-weight: 400;">{{$new_drivers}} out of {{$total_drivers}}</p>
                        </th>
                        @if($model != 'Settlement')
                            @if($model != 'CreditNote')
                                <th style="padding: 15px !important; font-size: medium;">
                                    {{__('automation.status')}}: <p style="font-weight: 400;">
                                        @if($status_id == 1)
                                        {{__('automation.pending')}}
                                        @elseif($status_id == 2)
                                        {{__('automation.rejected')}}
                                        @elseif($status_id == 3)
                                        {{__('automation.approved')}}
                                        @elseif($status_id == 4)
                                        {{__('automation.paid')}}
                                        @elseif($status_id == 5)
                                        {{__('automation.approved_by_supervisor')}}
                                        @endif
                                    </p>
                                </th>
                            @endif
                        @endif
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


        <div style=" clear: both;">
            <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="path" value="{{$path}}">
                <input type="hidden" name="credit_debbit" value="{{$credit_debbit}}">
                
                <input type="hidden" name="ACTION" value="{{$model}}">
                @if($model == 'CreditNote' || $model == 'Settlement')
                <input type="hidden" name="journal_check" value="{{$journal_check}}">
                @else
                
                <input type="hidden" name="status_id" value="{{$status_id}}">
                @endif

                <input type="hidden" name="journal_date" value="{{$journal_date}}">
                <input type="hidden" name="note" value="{{$note}}">
                
                <table id="customer_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <TH rowspan="2">{{__('automation.warehouse')}}</TH>
                        <TH rowspan="2">{{__('automation.driver_name')}}</TH>
                        <TH rowspan="2">{{__('automation.job_id')}}</TH>
                        <TH rowspan="2">{{__('automation.registration')}}</TH>
                        <TH rowspan="2">{{__('automation.note')}}</TH>
                        <TH rowspan="2">{{__('automation.carried_down')}}</TH>
                        <TH rowspan="2">{{__('automation.current_balance')}}</TH>
                        <TH colspan="2" style="text-align: center">@if($model != 'Settlement') {{__('automation.finance')}} @else {{__('automation.file_amount')}} @endif</TH>
                        @if($model != 'Settlement')
                            <TH rowspan="2">{{__('automation.file_amount')}}</TH>
                            @if($model != 'CreditNote')
                                <TH rowspan="2">{{__('automation.expected')}}</TH>
                            @endif
                        @endif
                        </tr>
                        <tr>
                            <TH>{{__('automation.credit')}}</TH>
                            <TH>{{__('automation.debit')}}</TH>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <TH rowspan="2">{{__('automation.warehouse')}}</TH>
                        <TH rowspan="2">{{__('automation.driver_name')}}</TH>
                        <TH rowspan="2">{{__('automation.job_id')}}</TH>
                        <TH rowspan="2">{{__('automation.registration')}}</TH>
                        <TH rowspan="2">{{__('automation.note')}}</TH>
                        <TH rowspan="2">{{__('automation.carried_down')}}</TH>
                        <TH rowspan="2">{{__('automation.current_balance')}}</TH>
                        <TH>{{__('automation.credit')}}</TH>
                        <TH>{{__('automation.debit')}}</TH>
                        @if($model != 'Settlement')
                            <TH rowspan="2">{{$amount}}</TH>
                            @if($model != 'CreditNote')
                            <TH rowspan="2">{{$expected}}</TH>
                            @endif
                        @endif
                        </tr>
                        <tr>
                            <TH colspan="2" style="text-align: center">@if($model != 'Settlement') Finance @else {{__('automation.file_amount')}} @endif</TH>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php echo $records; @endphp
                    </tbody>
                </table>
                <div class="col-md-12" style="margin: 20px; direction: rtl ">
                    <button type="submit" class="btn btn-success">{{__('automation.confirm')}}</button>
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
