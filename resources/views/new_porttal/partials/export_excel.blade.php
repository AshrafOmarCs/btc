<div class="modal fade" id="ExportExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Export Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row start -->
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-12">
                        <p>{{__('drivers.criteria_msg')}}. </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="table" style="width: 100%">
                            <tr>
                                <td>
                                   <input type="checkbox" name="" id="select_all" onclick="check_uncheck()"> Select all
                                </td>
                                <td>

                                </td>
                                <td class="secondList">
                                    <input type="checkbox" name="" id="select_all_second" onclick="check_uncheckSecond()"> Unselect all
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="list-group">
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item select_options"  id="option{{$k}}" onclick="selectOption('{{$k}}', '{{$option}}')" style="cursor: pointer;">{{$option}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="text-align: center;">
                                    <img style="width: 37px; margin-top: 4px; cursor: pointer;" id="forwardBtn" src="{{asset('assets/2735071.png')}}" onclick="pushSelected()" alt="">
                                    <br>
                                    <img style="width: 37px; margin-top: 53px; cursor: pointer;" id="reverseBtn" src="{{asset('assets/2985161.png')}}" onclick="popSelected()" alt="">
                                </td>
                                <td>
                                    <ul class="list-group secondList" class="secondList" id="secondListContent">
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item unselect_options"  id="unselect_option{{$k}}" onclick="unselectOption('{{$k}}')" style="cursor: pointer;"> &nbsp </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td style="text-align: right;">
                                    Total Select (<span style="color: red" id="totalSelected">0</span>)
                                </td>
                            </tr>
                            {{-- End-Footer --}}
                        </table>
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" style="background-color: red; border: 0;">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success" style="background-color: #2661ba; border: 0;" id="exportExcelBtn">{{__('drivers.Download')}}</button>
            </div>
        </div>
    </div>
</div>
