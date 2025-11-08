<kkiapay-widget
    amount="1000"
    key="{{ config('services.kkiapay.public') }}"
    callback="{{ route('paiement.callback') }}">
</kkiapay-widget>

<script src="https://cdn.kkiapay.me/k.js"></script>
