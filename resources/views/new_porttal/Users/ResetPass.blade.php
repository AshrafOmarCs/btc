
    @include('pages.messages2')
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/UserSaveResetPass')}}"    >
        @csrf
        <div class="modal-body">
            <table class="table m-0 show_table">
                <tr>
                    <th colspan="2">{{$User->name}}</th>
                </tr>
                <input type="hidden" name="id" value="{{$User->id}}">
                <tr><TH>Password <font color="red">*</font></TH>
                    <td>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </td></tr>
                <tr><TH>Confirm Password <font color="red">*</font></TH>
                    <td>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </td></tr>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit">Reset Password</button>
            </div>
        </div>
    </form>

