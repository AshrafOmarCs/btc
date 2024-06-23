@if(count($errors)>0)
    @foreach($errors->all() as $error)

        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" onclick="closeAlert()" data-dismiss="alert">&times;</button>
            <strong>Oh !</strong> {{$error}} and try submitting again.
        </div>



    @endforeach

@endif

@if(isset($success))

    <div class="alert alert-dismissible alert-success" style="width: 95%;margin: 15px auto;">
        <button type="button" class="close" onclick="closeAlert()" data-dismiss="alert">&times;</button>
        <strong>Well done!</strong> {{$success}}.
    </div>



@endif


@if(isset($error))

    <div class="alert alert-dismissible alert-danger" style="width: 95%;margin: 15px auto;">
        <button type="button" class="close" onclick="closeAlert()" data-dismiss="alert">&times;</button>
        <strong>Error !</strong> {{$error}} and try submitting again.
    </div>




@endif
