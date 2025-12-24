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
            cursor: pointer;
            transition: transform 0.2s;
        }
        .qr-card img:hover {
            transform: scale(1.05);
        }
        .qr-card p {
            font-weight: bold;
            margin-top: 10px;
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
                $modalId = 'modal_' . $filename;
            @endphp

            <div class="col-6 col-md-3 text-center qr-card">
                <img src="{{ asset('assets/paiement/code_qr/' . $file->getFilename()) }}"
                     alt="QR Code {{ $displayName }}"
                     class="img-fluid rounded shadow"
                     data-bs-toggle="modal"
                     data-bs-target="#{{ $modalId }}">
                <p>{{ $displayName }}</p>

                <!-- Modal pour le choix de paiement -->
                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="{{ $modalId }}Label">Paiement via {{ $displayName }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                      </div>
                      <div class="modal-body text-center">
                        <img src="{{ asset('assets/paiement/code_qr/' . $file->getFilename()) }}" class="img-fluid mb-3" style="max-height: 200px;">
                        <p>Scannez ce QR code avec votre application {{ $displayName }} pour effectuer le paiement.</p>
                        <button class="btn btn-primary mt-2">Payer maintenant avec {{ $displayName }}</button>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
