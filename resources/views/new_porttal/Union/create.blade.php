
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
        style="width:100%;font-size: 14px;font-weight: bold;">{{__('union.union')}}</h2>
</div>


<form method="POST" action="{{ route('Union.store')}}">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$union[0]->id ??  old('id') }}">
        <div class="table-responsive" style="width:100%;padding:0px 10px">
            <table style="width: 95%">
                <tr>
                    <td style="vertical-align: top !important;">
                        <table class="table table-bordered table-striped">

                            <tr>
                                <TH>{{__('union.name')}} <font color="red">*</font></TH>
                                <td><input type="text" class="form-control" name="name" value="{{$union[0]->name ??  old('name') }}" required></td>
                            </tr>
                            <tr>
                                <TH>{{__('union.description')}} <font color="red">*</font></TH>
                                <td><textarea style="width: 100%; height: 200px" class="form-control" name="description" value="{{$union[0]->description ??  old('description') }}" required>{{$union[0]->description ??  old('description') }}</textarea></td>
                            </tr>
                            <tr>
                                <TH>{{__('union.link')}} <font color="red">*</font></TH>
                                <td><input type="url" class="form-control" name="link" value="{{$union[0]->link ??  old('link') }}" required></td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{__('union.submit')}}</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('union.cancel')}}</button>
    </div>
</form>
