<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">QR Codes</h2>

    <div class="row justify-content-center g-4">
        <div class="col-md-4 text-center">
            <img src="{{ asset('') }}" alt="QR Code 1" class="img-fluid rounded shadow">
            <p class="mt-2">QR Code 1</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('qrcodes/qr2.png') }}" alt="QR Code 2" class="img-fluid rounded shadow">
            <p class="mt-2">QR Code 2</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('qrcodes/qr3.png') }}" alt="QR Code 3" class="img-fluid rounded shadow">
            <p class="mt-2">QR Code 3</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
