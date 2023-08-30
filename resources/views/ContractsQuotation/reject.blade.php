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
    </style>
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @else
        @if ($status === 0)
            <h1>You have already Rejected this quotation</h1>
        @elseif ($status === 1)
            <h1>You have already Accepted this quotation</h1>
        @else
        <h1>Quotation Request Rejected</h1>
        <p>Dear {{$company}},</p>
        <p>We regret to inform you that you rejected our quotation. Please provide us reason so that we can work on it.</p>
        <form action="{{ route('QuotationReject')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <p><strong>Rejection Reason:</strong></p>
            <textarea rows="5" style="width: 100%" name="reject_reason" required></textarea>
            <button type="submit" class="submit">Submit</button>
        </form>
        @endif
        @endif
        <p>If you have any questions or would like to discuss this further, please feel free to reach out to us.</p>
        <p>Best regards,</p>
        <p>Bandar Trading Company</p>
        <a href="https://btclogistic.com/" class="btn">Visit Our Website</a>
    </div>
</body>
</html>
