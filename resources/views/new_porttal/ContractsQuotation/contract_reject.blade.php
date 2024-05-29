<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Request Rejected</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .submit {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8a9af1;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        .submit:hover {
            background-color: #c82333; /* Change to a different color on hover */
        }
        .styled-input {
            width: 95%; /* Adjust the width as needed */
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none; /* Remove the default input outline */
        }

        /* Style the input field on focus */
        .styled-input:focus {
            border-color: #007bff; /* Change border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a subtle box shadow on focus */
        }

        /* Style a label for the input (optional) */
        .input-label {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @else
        @if ($status === 5)
            <h1>You have already Rejected this contract</h1>
        @elseif ($status === 4)
            <h1>You have already Accepted this contract</h1>
        @else
        <h1>Contract Request Rejection</h1>
        <p>Dear {{$company}},</p>
        <p>We regret to inform you that you are going to reject our contract. Please provide us reason so that we can work on it.</p>
        <form action="{{ route('ContractReject')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <p><strong>Rejection Reason:</strong></p>
            <textarea rows="5" style="" name="reject_reason" class="styled-input" required></textarea>
            <button type="submit" class="submit">Submit</button>
        </form>
        @endif
        @endif
        @if($status === 4 || $status === 5)
            <p>If you have any questions or would like to discuss this further, please feel free to reach out to us.</p>
            <a href="https://btclogistic.com/" class="btn">Visit Our Website</a>
        @endif
    </div>
</body>
</html>
