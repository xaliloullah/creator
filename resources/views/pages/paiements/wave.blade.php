<form class="needs-validation" novalidate>
    <div class="text-center mb-3">
        <img src="{{ asset('assets/images/payments/wave.png') }}" alt="wave" height="50">
        <h4 class="mb-1">Wave Money Payment</h4>
        <p class="text-muted mb-0">Enter your Wave Money details</p>
    </div>
    <div class="form-group">
        <input type="hidden" name="reference" value="{{ uniqid() }}" id="">
        <input type="hidden" name="methode" value="wave" required>

    </div>
    <div class="form-group">
        <label for="phone_number">Numéro de téléphone</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]{9,12}" required>
    </div>
</form>
