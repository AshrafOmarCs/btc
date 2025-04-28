@extends('layout2')
@section('content')
@section('title', __('automation.fin_operations'))
<style>
    .card1 {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 98%;
        /* margin-top: 150px; */
        margin-left: 13px;
        background-color: white;
        overflow-x: auto;
    }
</style>

 <!-- Row start -->

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('automation.fin_operations')}}</div>
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
                    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999;">
                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
                                <lottie-player
                                    src="https://assets9.lottiefiles.com/packages/lf20_usmfx6bp.json"
                                    background="transparent"
                                    speed="1"
                                    style="width: 200px; height: 200px;"
                                    loop
                                    autoplay>
                                </lottie-player>
                                <p style="margin-top:20px; font-size:18px; font-weight:bold; color:#555;">Fetching your data...</p>
                            </div>
                        </div>
                    <div id="box-body" class="box-body table-responsive">
                        <table class="table">
                            <tr>
                                <td style="padding: 15px !important">
                                    <button class="btn btn-info btn-small" id="daily" style="width: 190px; height: 100px" onclick="show_div('daily_div', 'daily')">{{__('automation.daily_load')}}</button>
                                </td>
                                <td style="padding: 15px !important">
                                    <button onclick="show_div('loans_div', 'loans')" id="loans" class="btn btn-info btn-small" style="width: 190px; height: 100px">{{__('automation.loans')}}</button>
                                </td>
                                <td style="padding: 15px !important">
                                    <button onclick="show_div('note_div', 'note')" id="note" class="btn btn-info btn-small" style="width: 190px; height: 100px">{{__('automation.credit_note')}}</button>
                                </td>
                                <td style="padding: 15px !important">
                                    <button onclick="show_div('settlements_div', 'settlements')" id="settlements" class="btn btn-info btn-small" style="width: 190px; height: 100px">{{__('automation.settlements')}}</button>
                                </td>
                                <td style="padding: 15px !important">
                                    <button onclick="show_div('unroll_div', 'unroll')" id="unroll" class="btn btn-info btn-small" style="width: 190px; height: 100px">{{__('automation.unroll_records')}}</button>
                                </td>

                            </tr>
                        </table>
                        {{-- <div class="card-footer" align="center">
                            <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">{{__('automation.filter')}}</button>

                            <button type="button" name="reset" id="reset" class="btn btn-sm btn-default">{{__('automation.reset')}}</button>
                        </div> --}}
                    </div>
                    <div class="card1">
                        <div style="width: 100%; clear: both; display: none; margin-top: 100px; margin-bottom: 100px;" id="response">
                            <center>
                                <img src="/AdminLTE/img/ajaxloader.gif" width="80" height="80" alt="Loading...">
                            </center>
                        </div>
                        <div style="width: 95%; clear: both;" id="data">
                            <div class="row" style="display: none" id="daily_div">
                                    <div class="col-md-8" style="border-right: 1px solid">
                                        <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data" id="monthly_daily_salary_form">
                                            @csrf
                                            <input type='hidden' name="READ" value='daily'>
                                            <div class="col-md-12">
                                                <h4>{{__('automation.bulk_upload')}}</h4>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{__('automation.file_type')}}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="file_type" id="file_type" class="form-control"  onchange="show_right_table(this.value)" required>
                                                    <option value="">{{__('automation.select_type')}}</option>
                                                    <option value="Half">{{__('automation.half_salary')}}</option>
                                                    <option value="Monthly">{{__('automation.monthly_salary')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{__('automation.journal_date')}}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" name="journal_date" id="journal_date" class="form-control"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 salary_table">
                                                <label>{{__('automation.note')}}</label>
                                            </div>
                                            <div class="col-md-6 salary_table">
                                                <input type="text" name="note" id="notee" placeholder="Write note here" class="form-control"  required>
                                            </div>
                                            <div class="col-md-6 salary_table">
                                                <label>{{__('automation.status')}}</label>
                                            </div>
                                            <div class="col-md-6 salary_table">
                                                <select name="status_id" id="status_idd" class="form-control"  required>
                                                    <option value="">{{__('automation.select_status')}}</option>
                                                    <option value="1">{{__('automation.pending')}}</option>
                                                    <option value="3">{{__('automation.approved')}}</option>
                                                    <option value="4">{{__('automation.paid')}}</option>
                                                    <option value="5">{{__('automation.approved_by_supervisor')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{__('automation.file')}}:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="file" name="select_file" id="file" class="form-control salary_monthly_file" accept=".xls, .xlsx, .csv"  required>
                                            </div>
                                            <div class="col-md-12" style="margin: 20px; direction: rtl;">
                                                <button type="submit" class="btn btn-success">{{__('automation.continue')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4" id="right_table" style="display: none">
                                        <div class="col-md-12 monthly_table">
                                            <p>{{__('automation.sequence_flow_guide')}} <br><br>
                                                <a href="{{ url('/storage/docsFormat/ImileInvoiceFormat.csv') }}" class="btn btn-sm btn-info" style="padding: 10px"><i class="fa fa-download"></i> {{__('automation.here')}}</a>
                                            </p>
                                        </div>
                                        <div class="col-md-12 monthly_table">
                                            <table id="customer_data" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('automation.cell')}}</th>
                                                        <th>{{__('automation.header')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>A1</td>
                                                        <td>{{__('automation.hub_name')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B1</td>
                                                        <td>{{__('automation.job_id')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>C1</td>
                                                        <td>{{__('automation.name')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D1</td>
                                                        <td>{{__('automation.number_TP')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E1</td>
                                                        <td>{{__('automation.number_days')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>F1</td>
                                                        <td>{{__('automation.driver_type')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>G1</td>
                                                        <td>{{__('automation.rate')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>H1</td>
                                                        <td>{{__('automation.net_salary')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 salary_table">
                                            <p>{{__('automation.sequence_flow_guide')}}
                                                <form method="POST" action="{{route('Automation/download_file')}}" onsubmit="enableDownloadType()">
                                                    @csrf
                                                    <input type='hidden' id='download_type' name='download_type' value='daily'>
                                                    <button type="submit" style="padding: 10px" class="btn btn-sm btn-info"><i class="fa fa-download"></i> {{__('automation.here')}}</button>
                                                </form>
                                            </p>
                                        </div>
                                        <div class="col-md-12 salary_table">
                                            <table id="customer_data" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('automation.cell')}}</th>
                                                        <th>{{__('automation.header')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>A1</td>
                                                        <td>{{__('automation.hub_name')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B1</td>
                                                        <td>{{__('automation.job_id')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>C1</td>
                                                        <td>{{__('automation.name')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D1</td>
                                                        <td>{{__('automation.amount')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <p>{{__('automation.helpdesk')}}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="row" style="display: none" id="loans_div">
                                <div class="col-md-8" style="border-right: 1px solid">
                                    <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type='hidden' name="READ" value='Loans'>
                                        <div class="col-md-12"  >
                                            <h4>{{__('automation.bulk_upload')}}</h4>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.journal_date')}}</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" name="journal_date" id="journal_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.note')}}</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <input type="text" name="note" id="note" placeholder="Write note here" class="form-control" required>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.status')}}:</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <select name="status_id" id="status_id" class="form-control" required>
                                                <option value="">{{__('automation.select_status')}}</option>
                                                <option value="1">{{__('automation.pending')}}</option>
                                                <option value="3">{{__('automation.approved')}}</option>
                                                <option value="4">{{__('automation.paid')}}</option>
                                                <option value="5">{{__('automation.approved_by_supervisor')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.file')}}:</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <input type="file" name="select_file" id="file" accept=".xls, .xlsx" class="form-control" required>
                                        </div>
                                        <div class="col-md-12" style="margin: 20px; direction: rtl;">
                                            <button type="submit" class="btn btn-success">{{__('automation.continue')}}</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.sequence_flow_guide')}}
                                            <form method="POST" action="{{route('Automation/download_file')}}" onsubmit="enableDownloadType()">
                                                @csrf
                                                <input type='hidden' id='download_type' name='download_type' value='daily'>
                                                <button type="submit" style="padding: 10px" class="btn btn-sm btn-info "> <i class="fa fa-download"></i> {{__('automation.here')}}</button>
                                            </form>
                                        </p>
                                    </div>
                                    <div class="col-md-12"  >
                                        <table id="customer_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{__('automation.cell')}}</th>
                                                    <th>{{__('automation.header')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A1</td>
                                                    <td>{{__('automation.hub_name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                    <td>{{__('automation.job_id')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>C1</td>
                                                    <td>{{__('automation.name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>D1</td>
                                                    <td>{{__('automation.amount')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.helpdesk')}}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="display: none" id="settlements_div">
                                <div class="col-md-8" style="border-right: 1px solid">
                                    <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type='hidden' name="READ" value='settlement'>
                                        <div class="col-md-12"  >
                                            <h4>{{__('automation.bulk_upload')}}</h4>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.journal_date')}}</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" name="journal_date" id="journal_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  >
                                            <label>{{__('automation.file')}}:</label>
                                        </div>
                                        <div class="col-md-6"  >
                                            <input type="file" name="select_file" id="file" accept=".xls, .xlsx" class="form-control" required>
                                        </div>
                                        <div class="col-md-10"  >
                                            <input type="radio" id="credit" name="credit_debit" value="credit" required>
                                            <label for="credit">{{__('automation.credit')}}</label><br>
                                            <input type="radio" id="debit" name="credit_debit" value="debit" required>
                                            <label for="debit">{{__('automation.debit')}}</label><br>
                                        </div>
                                        <div class="col-md-10"  >
                                            <label><input type="checkbox" name="journal_check" id="journal_check" class=""> {{__('automation.post_to_journal')}}</label>
                                            <br><small style="color: #ff9966">{{__('automation.journal_alert')}}</small>
                                        </div>
                                        <div class="col-md-12" style="margin: 20px; direction: rtl;">
                                            <button type="submit" class="btn btn-success">{{__('automation.continue')}}</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.sequence_flow_guide')}}
                                            <form method="POST" action="{{route('Automation/download_file')}}" onsubmit="enableDownloadType()">
                                                @csrf
                                                <input type='hidden' id='download_type' name='download_type' value='settlement'>
                                                <button type="submit" style="padding: 10px" class="btn btn-sm btn-info "> <i class="fa fa-download"></i> {{__('automation.here')}}</button>
                                            </form>
                                        </p>
                                    </div>
                                    <div class="col-md-12"  >
                                        <table id="customer_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{__('automation.cell')}}</th>
                                                    <th>{{__('automation.header')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A1</td>
                                                    <td>{{__('automation.hub_name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                    <td>{{__('automation.job_id')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>C1</td>
                                                    <td>{{__('automation.name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>D1</td>
                                                    <td>{{__('automation.note')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>E1</td>
                                                    <td>{{__('automation.amount')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.helpdesk')}}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="display: none" id="note_div">
                                <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data" class="col-md-8" style="border-right: 1px solid">
                                    @csrf
                                    <input type='hidden' name="READ" value='creditNote'>
                                    <div class="col-md-12"  >
                                        <h4>{{__('automation.bulk_upload')}}</h4>
                                    </div>
                                    <div class="col-md-6"  >
                                        <label>{{__('automation.journal_date')}}</label>
                                    </div>
                                    <div class="col-md-6"  >
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control" name="journal_date" id="journal_date" type="date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6"  >
                                        <label>{{__('automation.file')}}:</label>
                                    </div>
                                    <div class="col-md-6"  >
                                        <input type="file" name="select_file" id="file" accept=".xls, .xlsx" class="form-control" required>
                                    </div>
                                    <div class="col-md-12"  >
                                        <label>
                                            <input type="checkbox" name="journal_check" id="journal_check" class=""> {{__('automation.post_to_journal')}}
                                        </label>
                                        <br>
                                        <small style="color: #ff9966">{{__('automation.journal_alert')}}</small>
                                    </div>
                                    <div class="col-md-12" style="margin: 20px; direction: rtl;">
                                        <button type="submit" class="btn btn-success">{{__('automation.continue')}}</button>
                                    </div>
                                </form>

                                <div class="col-md-4">
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.sequence_flow_guide')}}</p>
                                        <form method="POST" action="{{route('Automation/download_file')}}" onsubmit="enableDownloadType()">
                                            @csrf
                                            <input type='hidden' id='download_type' name='download_type' value='note'>
                                            <button type="submit" style="padding: 10px" class="btn btn-sm btn-info">
                                                <i class="fa fa-download"></i> {{__('automation.here')}}
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-12"  >
                                        <table id="customer_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{__('automation.cell')}}</th>
                                                    <th>{{__('automation.header')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A1</td>
                                                    <td>{{__('automation.hub_name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                    <td>{{__('automation.job_id')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>C1</td>
                                                    <td>{{__('automation.name')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>D1</td>
                                                    <td>Note</td>
                                                </tr>
                                                <tr>
                                                    <td>E1</td>
                                                    <td>{{__('automation.amount')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12"  >
                                        <p>{{__('automation.helpdesk')}}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="display: none" id="unroll_div">
                                <form action="{{ route('automation/upload')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type='hidden' name="READ" value='Unroll'>
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <h4>{{__('automation.bulk_unroll')}}</h4>
                                        </div>
                                        <div class="col-md-6" >
                                            <label>{{__('automation.select_module_msg')}}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="module" id="module" class="form-control"  onchange="show_checkboxes(this.value)" required>
                                                <option value="">{{__('automation.select_module')}}</option>
                                                <option value="Half-salary">{{__('automation.salary')}}</option>
                                                <option value="Loan">{{__('automation.loans')}}</option>
                                                <option value="CreditNote">{{__('automation.credit_note')}}</option>
                                                <option value="Settlement">{{__('automation.settlements')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" >
                                            <label>{{__('automation.company')}}:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="companyId" id="companyId" class="form-control"  onchange="WarehouseName()" required>
                                                    <option value="">{{__('automation.select_company')}}</option>
                                                    @foreach($companies as $company)
                                                        <option value={{$company->id}}>{{$company->companyName}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6" >
                                            <label>{{__('automation.warehouse')}}:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="warehouseId[]" id="warehouseId" class="form-control" style="width: 100%;" multiple>
                                                    <option value="">{{__('automation.select_warehouse')}}</option>
                                            </select>
                                            <small id='multipl' style="color: red; display: none">{{__('automation.select_warehouse_msg')}}</small>
                                        </div>
                                        <div class="col-md-6" >
                                            <label>{{__('automation.period')}}:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker-range" id="journal_date_1" name="journal_date_1" value="">
                                            </div>
                                        </div>
                                        <div id="checks_div" class="col-md-12" style=" display: none ">
                                            <input type="checkbox" id="credit" name="credit" value="credit">
                                            <label for="credit"> {{__('automation.credit')}}</label><br>
                                            <input type="checkbox" id="debit" name="debit" value="debit">
                                            <label for="debit"> {{__('automation.debit')}}</label><br>
                                        </div>

                                        <div class="col-md-12" style="margin: 20px; direction: rtl">
                                            <button type="submit" class="btn btn-success">{{__('automation.continue')}}</button>
                                        </div>
                                    </div>
                                </form>


                            </div>

                        </div>
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
        function WarehouseName() {
            var filter_companyId = document.getElementById('companyId').value;
            $('#warehouseId').empty();
            if(filter_companyId > 0) {
                $.getJSON("getWarehouseName" + "/" + filter_companyId, function (json) {
                    $('#warehouseId').empty();
                    // $('#warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                        $('#multipl').show();
                    });
                });
            } else {
                $('#warehouseId').empty();
                $('#warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $('#multipl').hide();
            }
        }
        function show_right_table(type) {
            if(type == 'Half') {
                var newActionUrl = '{{url('automation/upload')}}';
                $('#monthly_daily_salary_form').attr('action', newActionUrl);
                $('.salary_table').show();
                $('.salary_monthly_file').attr('accept', ".xls, .xlsx");
                $('#notee').attr('required', true);
                $('#status_idd').attr('required', true);
                $('.monthly_table').hide();
                $('#right_table').show();
            } else if(type == 'Monthly') {
                var newActionUrl = '{{url('i-mile/preview')}}';
                $('#monthly_daily_salary_form').attr('action', newActionUrl);
                $('.salary_monthly_file').attr('accept', ".csv, .xls, .xlsx");
                $('#notee').attr('required', false);
                $('#status_idd').attr('required', false);
                $('.salary_table').hide();
                $('.monthly_table').show();
                $('#right_table').show();
            } else
                $('#right_table').hide();
        }
        function show_checkboxes(type) {
            if(type == 'Settlement')
                $('#checks_div').show();
            else
                $('#checks_div').hide();
        }
        function download_file(type) {
            $.ajax({
                type: 'POST',
                url: "{{url('Automation/download_file')}}",
                cache: false,
                data: {
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    // document.getElementById('response').innerHTML = data;
                }
            });
        }
        function show_div(div, btn) {
            $('#data').hide();
            $('#response').show();
            setTimeout(function() {
                $('#response').hide();
                $('#data').show();
            }, 1000);
            if ($('#daily').hasClass('btn-success')) {
                $('#daily').removeClass('btn-success').addClass('btn-info');
                $('#daily_div').hide();
            }
            if ($('#loans').hasClass('btn-success')) {
                $('#loans').removeClass('btn-success').addClass('btn-info');
                $('#loans_div').hide();
            }
            if ($('#settlements').hasClass('btn-success')) {
                $('#settlements').removeClass('btn-success').addClass('btn-info');
                $('#settlements_div').hide();
            }
            if ($('#note').hasClass('btn-success')) {
                $('#note').removeClass('btn-success').addClass('btn-info');
                $('#note_div').hide();
            }
            if ($('#unroll').hasClass('btn-success')) {
                $('#unroll').removeClass('btn-success').addClass('btn-info');
                $('#unroll_div').hide();
            }
            $('#'+div).show();
            $('#'+btn).removeClass('btn-info').addClass('btn-success');

            // if ($('#'+btn).hasClass('btn-info')) {
            //     $('#'+btn).removeClass('btn-info').addClass('btn-success');
            // }
            // else {
            //     $('#'+btn).removeClass('btn-success').addClass('btn-info');
            // }

        }
        // function enableDownloadType() {
        //     let val = $("#download_type").val();
        //     $("#download_type").val(val);
        // }

    </script>
@stop
@endsection
