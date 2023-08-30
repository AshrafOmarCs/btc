<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syinc Drivers from SANED</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body style="padding: 22px;">
    <form method="post" action="{{url('/Syinc-drivers-sanad/store')}}">
        @csrf
        <div class="form-group">
            <label for="URL_link">URL </label>
            <textarea required name="URL" class="form-control" id="URL_link" rows="3"></textarea>
            <small id="emailHelp" class="form-text text-muted">Paste SANED url after modifing it here .</small>
        </div>

        <div class="form-group">
            <label for="SANEDCookie">SANED Cookie token </label>
            <textarea required name="Cookie" class="form-control" id="SANEDCookie" rows="3"></textarea>
        </div>
        
        <div class="form-group">
            <label for="warehouse_id">Branch </label>
            <select required class="form-control" id="warehouse_id" name="warehouse_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->warehouseName}}</option>
                @endforeach
            </select>
        </div>
            
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>