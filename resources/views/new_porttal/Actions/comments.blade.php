@extends('layout2')
@section('content')
@section('title', 'Ticketing Comments')

@php
$module = "Ticketing Comments";
@endphp
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Accept Settlement(s) </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ticketing Comments</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">The comments for Support Ticket(<span style="color: green">{{$action[0]->module}}</span>)</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <a href="/New-Portal/Requires_action"><button type="button" class="btn btn-primary" data-bs-toggle="modal" type="button" data-bs-target="#addNewTicket"></i>Back</button></a>
                                @if($action[0]->status  != 'Closed')
                                    <button class="btn btn-warning closed" onclick="closeTicket({{$action[0]->id}})">Close Ticket</button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="loader" style="display:none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <!-- Card start -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Comments</div>
                                </div>
                                <div class="card-body">
                                    <div class="scroll300">
                                        <ul class="chats" id="chatUl">
                                            @foreach ($comments as $comment)
                                                @php
                                                    $time = explode(" ", $comment->created_at);
                                                    $name = explode(" ", $comment->name);
                                                @endphp
                                                <li class="@if($comment->created_by == AUTH::user()->id) chats-right @else chats-left @endif">
                                                    <div class="chats-avatar">
                                                        <img src="/dashboard/assets/logos/user.png" alt="Admin Panel">
                                                        <div class="chats-name">{{$comment->created_by == AUTH::user()->id ? 'You' : $name[0]}}</div>
                                                    </div>
                                                    <div class="chats-text">{{$comment->comment}}</div>
                                                    <div class="chats-hour">{{$comment->created_at}} <span class="icon-done_all"></span></div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @if($action[0]->status  != 'Closed')
                                        <div class="scroll10 closed">
                                            <ul class="chats">
                                                <li class="chats-left" style="display: flex">
                                                    <div class="chats-avatar">
                                                        <img src="/dashboard/assets/logos/user.png" alt="Admin Panel">
                                                        <div class="chats-name">You</div>
                                                    </div>
                                                    <div class="chats-text" style="width: 85%; margin-left: 2%;">
                                                        <input type="text" name="comment" id="comment" class="form-control">
                                                    </div>
                                                    <img style="width: 5%; margin-top: 1%; cursor: pointer;" src="https://cdn-icons-png.freepik.com/256/10924/10924424.png" onclick="addComment()">
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Card end -->
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }
        function addComment() {
            let msg = $('#comment').val();
            if (msg != '') {
                $.ajax({
                    type: 'POST',
                    url: "{{URL('/New-Portal/Requires_action/saveComment')}}",
                    data : {
                        comment : msg,
                        action_id : {{$action[0]->id}},
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        if (data == 'Good') {
                            let html = `<li class="chats-right">
                                <div class="chats-avatar">
                                    <img src="/dashboard/assets/logos/user.png" alt="Admin Panel">
                                    <div class="chats-name">You</div>
                                </div>
                                <div class="chats-text">` + msg + `</div>
                                <div class="chats-hour">` + getCurrentTime() + ` <span class="icon-done_all"></span></div>
                            </li>`;
                            var ul = document.getElementById("chatUl");
                            var li = document.createElement("li");
                            li.innerHTML = html;
                            ul.appendChild(li);
                            $('#message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Comment Added Successfully!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Something went wrong!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                    },
                    error: function(xhr) {
                        $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Something went wrong!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                });
            }
            $('#comment').val('');
        }
        function closeTicket(id) {
            Swal.fire({
                html: `<span style="text-align: center;">
                    Are you sure, Want to close this Ticket?
                    </span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{URL('/New-Portal/Requires_action/closeTicket')}}",
                        data : {
                            id : id,
                            _token: '{{csrf_token()}}'
                        }, success: function (data) {
                            if (data == 'Good') {
                                $('.closed').remove();
                                Swal.fire({
                                    title: 'Ticket Closed Successfully!',
                                    icon: 'success',
                                    confirmButtonText: 'Okay',
                                });
                                // $('#message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Ticket Closed Successfully!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Something went wrong!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }
                        }, error: function(xhr) {
                            $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Something went wrong!<button type="button" onclick="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                    });
                }
            });
        }
    </script>
@stop
@endsection

