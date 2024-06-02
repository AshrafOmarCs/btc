<style>
    .rte-floatpanel-paragraphop {
        display: none !important;
    }

    .table-container {
        max-height: 450px; /* Set the maximum height of the container */
        overflow-y: auto; /* Enable vertical scrollbar when content exceeds the height */
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">New {{$type == 'cat' ? 'Category' : 'Property'}}</h2>
</div>
<div class="modal-body">
@if($type == 'cat')
<form method="POST" action="{{ route('PropertyIssuance/store')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="cat_id" id="cat_id" value="0">
    <div class="row">
        <div class="col-xl-1 col-sm-1 col-1">
            <div class="mt-2 ml-3">
                <h6 for="country">{{__('properties.name')}} <font color="red">*</font></h6>
            </div>
        </div>
        <div class="col-xl-9 col-sm-9 col-9">
            <div class="mb-3 d-flex">
                <input type="text" class="form-control" placeholder="{{__('properties.category_name')}}" id="name" name="name" value="" required aria-describedby="button-addon2">
                <button type="submit" class="btn btn-primary" type="button" id="button-addon2">{{__('properties.add')}}</button>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="table-container">
            <table id="customer_data table table-bordered table-striped" style="width: 100%">
                <thead>
                    <th>{{__('properties.sr_no')}}</th>
                    <th>{{__('properties.name')}}</th>
                    <th>{{__('properties.added_by')}}</th>
                    <th>{{__('properties.added_on')}}</th>
                    <th>{{__('properties.action')}}</th>
                </thead>
                <tbody id="category_body">
                    @php $i = 1; @endphp
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->user_name}}</td>
                            <td>{{$category->created_at}}</td>
                            <td>
                                <a onclick="edit_record({{$category->id}}, '{{$type}}', '{{$category->name}}')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="bi bi-pencil-square"></i> </a>
                                &nbsp;<a onclick="delete_record({{$category->id}})" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="bi bi-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
@else
<form method="POST" action="{{ route('PropertyIssuance/store')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <input type="hidden" name="type" value="{{$type}}">
    <div class="row">
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.name')}}</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.property_type')}}</label>
                <Select class="form-control" id="property_id" name="property_id" required>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </Select>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.description')}}</label>
                <textarea class="form-control" id="description" name="description" value="" required></textarea>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.price')}}</label>
                <input type="number" min="0" class="form-control" id="price" name="price" value="" required>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.status')}}</label>
                <select class="form-control" id="status_id" name="status_id" required>
                    <option value="">Select status</option>
                    @foreach($status as $sta)
                        <option value="{{$sta->id}}">{{$sta->status}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.branch')}}</label>
                <select class="form-control" id="branches" name="branches" required onchange="add_new_branch(this.value)">
                    <option value="">Select branch</option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->branches}}">{{$branch->branches}}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12" style="display: none" id="new_branch">
            <div class="mb-3">
                <label for="country" class="form-label">{{__('properties.branch_name')}}</label>
                <input type="text" class="form-control" id="new_branches" name="new_branches" value="">
            </div>
        </div>


    </div>
    <div class="row">
        <button class="btn btn-primary" type="submit">{{__('properties.submit')}}</button>
    </div>
</form>
@endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
</div>

