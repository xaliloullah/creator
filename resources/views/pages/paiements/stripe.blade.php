<form class="needs-validation" novalidate>
    <div class="text-center mb-3">
        <img src="{{ asset('assets/images/payments/stripe.png') }}" alt="stripe" height="50">
    </div>
    <div class="form-group">
        <input type="hidden" name="methode" value="stripe" required>
    </div>
    <div class="card">
        <div id="card-element" class="p-5 text-dark shadow"></div>
    </div>
</form>
<script>
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var form = document.getElementById('form-step-3');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                console.error(result.error.message);
            } else {
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    });
</script>
