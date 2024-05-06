<style>
    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
</style>


<br><br><br><br>
@include('pages.messages2')

@if(!  isset($success))
<header class="w3-container w3-text-indigo w3-margin-top-64">
    <h1>Delete</h1>
</header>
<form class="w3-container" action="{{ URL('/DriversClaimDeleteAction')}}" onsubmit="return validateDelete()" method="POST" id="delete_form">
    {{method_field('DELETE')}}
    @csrf
    <input type="hidden" name="drivers_jahiz_claim_id" value="{{$id}}">
    <div class="w3-section">
        <p>Are you sure, you want to delete <span id="delete_name"></span> ?</p>
        <div class="w3-center">
            <button type="submit" class="w3-btn w3-indigo"> Delete</button>
        </div>
    </div>
</form>
@endif






