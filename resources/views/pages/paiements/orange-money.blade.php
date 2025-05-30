<form class="needs-validation" novalidate>
    <div class="text-center mb-3">
        <img src="{{ asset('assets/images/payments/orange-money.png') }}" alt="orange-money" height="50">
        <h4 class="mb-1">Orange Money Payment</h4>
        <p class="text-muted mb-0">Enter your Orange Money details</p>
    </div>
    <div class="form-group">
        <input type="hidden" id="amount" name="amount" value="{{ $tarif->prix }}" required>
        <input type="hidden" name="reference" value="{{ uniqid() }}" id="">
        <input type="hidden" name="methode" value="orange-money" required>

    </div>
    <div class="form-group">
        <label for="phone_number">Numéro de téléphone (Orange Money)</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]{9,12}" required>
    </div>
</form>
