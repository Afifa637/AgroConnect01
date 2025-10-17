<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <link href="{{ url('final_eagri/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f6fff7;
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }
        th {
            background: #d8f3dc;
            color: #1b4332;
        }
        h3 {
            color: #1b4332;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #2d6a4f;
        }
    </style>
</head>
<body>

<div class="container invoice-box">
    <h3 class="text-center">Order Invoice Information</h3>
    <table class="table table-bordered text-center align-middle">
        <tr>
            <th>Farmer Username</th>
            <td>{{ $order->f_username }}</td>
        </tr>
        <tr>
            <th>Customer Username</th>
            <td>{{ $order->c_username }}</td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td>{{ $order->name }}</td>
        </tr>
        <tr>
            <th>Crop Name</th>
            <td>{{ $crop->crop_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Customer Email</th>
            <td>{{ $order->email }}</td>
        </tr>
        <tr>
            <th>Customer Phone</th>
            <td>{{ $order->phone }}</td>
        </tr>
        <tr>
            <th>Payment Amount</th>
            <td>{{ $order->amount }} BDT</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $order->address }}</td>
        </tr>
        <tr>
            <th>Division</th>
            <td>{{ $order->division }}</td>
        </tr>
        <tr>
            <th>Zip Code</th>
            <td>{{ $order->zip }}</td>
        </tr>
        <tr>
            <th>Transaction ID</th>
            <td>{{ $order->transaction_id }}</td>
        </tr>
        <tr>
            <th>Currency</th>
            <td>{{ $order->currency }}</td>
        </tr>
        <tr>
            <th>Crop Image</th>
            <td><img src="{{ url($crop->crop_image) }}" width="200" height="150" alt="Crop Image"></td>
        </tr>
    </table>

    <div class="footer">
        <p>Thank you for using <img src="{{ asset('final_eagri/img/agri.png') }}" alt="Agro Logo" width="100"> Limited</p>
    </div>
</div>

</body>
</html>
