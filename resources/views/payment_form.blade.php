<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Test Payment Gateway</h2>

        <form action="{{ route('payment') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="amount">Amount (BDT):</label>
                <input type="number" id="amount" name="amount" class="form-control" value="100" required>
            </div>

            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" class="form-control" value="Nazmul" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Customer Email:</label>
                <input type="email" id="customer_email" name="customer_email" class="form-control" value="test@gmail.com" required>
            </div>

            <button type="submit" class="btn btn-primary">Proceed with Payment</button>
        </form>
    </div>
</body>
</html>
