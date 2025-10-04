<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f8fff7;
        font-family: 'Poppins', sans-serif;
    }
    .invoice-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-top: 40px;
    }
    .invoice-header {
        color: #2d6a4f;
        font-weight: 600;
    }
    table th {
        background-color: #95d5b2;
        color: #fff;
    }
</style>

<div class="container invoice-container">
    <h2 class="text-center invoice-header mb-4"><i class="fas fa-file-invoice"></i> Confirm Details Invoice</h2>

    <table class="table table-bordered text-center align-middle">
        <tbody>
            <tr><th>Customer Name:</th><td>{{$Bid->cust_username}}</td></tr>
            <tr><th>Crop Name:</th><td>{{$Bid->crop_name}}</td></tr>
            <tr><th>Farmer Name:</th><td>{{$Bid->f_username}}</td></tr>
            <tr><th>Farmer Email:</th><td>{{$user->email}}</td></tr>
            <tr><th>Farmer Mobile:</th><td>{{$user->mobile}}</td></tr>
            <tr><th>Farmer Division:</th><td>{{$user->division}}</td></tr>
            <tr><th>Farmer Address:</th><td>{{$user->address}}</td></tr>
            <tr><th>Zip Code:</th><td>{{$user->zip_code}}</td></tr>
            <tr><th>Account Type:</th><td>{{$msg->account_type}}</td></tr>
            <tr><th>Account ID:</th><td>{{$msg->account_id}}</td></tr>
            <tr><th>Bid Price:</th><td class="fw-bold text-success">{{$Bid->bid_price}}৳</td></tr>
            <tr><th>Confirm Price:</th><td class="fw-bold text-success">{{$msg->confirm_price}}৳</td></tr>
            <tr><th>Message:</th><td>{{$msg->message}}</td></tr>
            <tr><th>Send Date:</th><td>{{$msg->created_at}}</td></tr>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <small class="text-muted">Welcome from</small>
        <img src="{{ url('final_eagri/img/agri.png')}}" width="100" alt="AgroConnect Logo">
        <small class="text-muted">Limited</small>
    </div>
</div>
