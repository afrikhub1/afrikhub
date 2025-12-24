<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qr-card img {
            max-height: 200px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">QR Codes Paiement</h2>

    <div class="row justify-content-center g-4">
        @php
            $path = public_path('assets/paiement/code_qr');
            $files = File::files($path);
        @endphp

        @foreach ($files as $file)
            @php
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $displayName = ucfirst($filename);
            @endphp
            <div class="col-6 col-md-3 text-center qr-card">
                <img src="{{ asset('assets/paiement/code_qr/' . $file->getFilename()) }}" alt="QR Code {{ $displayName }}" class="img-fluid rounded shadow">
                <p class="mt-2">{{ $displayName }}</p>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
