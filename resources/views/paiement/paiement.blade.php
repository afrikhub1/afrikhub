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
            <img src="{{ asset('storage/code_qr/moov.jpg') }}" alt="QR Code 1" class="img-fluid rounded shadow">
            <p class="mt-2">Moov</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/code_qr/orange.jpg') }}" alt="QR Code 2" class="img-fluid rounded shadow">
            <p class="mt-2">Orange</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/code_qr/mtn.jpg') }}" alt="QR Code 3" class="img-fluid rounded shadow">
            <p class="mt-2">MTN</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/code_qr/wave.jpg') }}" alt="QR Code 3" class="img-fluid rounded shadow">
            <p class="mt-2">Wave</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
