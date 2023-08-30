@extends('AdminLTE')
@section('content')

    <section class="content-header">
        <h1>
            Version Control
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Version Control of App</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row col-md-4">
                            <form method="POST" action="{{ route('versionControl.update',$app_version->id)}}">
                                {{method_field("PATCH")}}
                                @csrf
                                <form class="table m-0 show_table" style="width:10px!important;">

                                        <label>	Version <font color="red">*</font></label>

                                            <input type="text" class="form-control"  name="version" id="version"
                                                   value="{{$app_version->version}}" required autocomplete="name" autofocus>

                                        <label>	App Name <font color="red">*</font></label>

                                            <select name="app" id="	app" placeholder="Select ..." class="form-control" required>
                                                <option value="Android">Android</option>
                                            </select>

                                        <label>	Version Code <font color="red">*</font></label>

                                            <input name="versionCode" id="versionCode" placeholder="Select ..." value="{{ $app_version->versionCode }}" class="form-control" required>
                                    <div class="w3-row">
                                        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Update</button>
                                    </div>

                                </form>
                        </div><!-- /.row -->
                    </div><!-- ./box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>



    </section>





@endsection
