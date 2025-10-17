<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bid Invoice</title>
    <link href="{{ public_path('final_eagri/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 20px;
        }
        h3 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            font-size: 14px;
        }
        th {
            background-color: #f8f9fa;
            color: #198754;
        }
        td, th {
            vertical-align: middle !important;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #555;
        }
        .footer img {
            height: 25px;
            vertical-align: middle;
            margin-right: 5px;
        }
        .footer a {
            text-decoration: none;
            color: #198754;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row flex-sm-row my-5">
        <div class="col-md-12 col-sm-12">
            <h3 class="text-center text-success">Bid Invoice Info</h3>
            <table class="table table-bordered text-center">
                <tr>
                    <th>Crop Name:</th>
                    <td>{{ $Bid->crop_name }}</td>
                </tr>
                <tr>
                    <th>Farmer Username:</th>
                    <td>{{ $Bid->f_username }}</td>
                </tr>
                <tr>
                    <th>Customer Username:</th>
                    <td>{{ $Bid->cust_username }}</td>
                </tr>
                <tr>
                    <th>Customer Email:</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Customer Mobile:</th>
                    <td>{{ $user->mobile }}</td>
                </tr>
                <tr>
                    <th>Customer Division:</th>
                    <td>{{ $user->division }}</td>
                </tr>
                <tr>
                    <th>Customer Address:</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th>Customer Zip Code:</th>
                    <td>{{ $user->zip_code }}</td>
                </tr>
                <tr>
                    <th>Bid Price:</th>
                    <td>{{ $Bid->bid_price }}</td>
                </tr>
                <tr>
                    <th>Message:</th>
                    <td>{{ $Bid->message }}</td>
                </tr>
                <tr>
                    <th>Send Date:</th>
                    <td>{{ $Bid->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>
            Welcome from 
            <img src="{{ public_path('final_eagri/img/agri.png') }}" alt="AgroConnect Logo">
            <a>AgroConnect Limited</a><br>
            Thank you for using AgroConnect! Keep this invoice for your records.
        </p>
    </div>
</div>

</body>
</html>
