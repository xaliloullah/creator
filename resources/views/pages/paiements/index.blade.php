@extends('includes.index')
@section('title', 'Paiement')
<script src="https://js.stripe.com/v3/"></script>

@section('content')
    @push('styles')
        <style>
            .payment-step {
                display: none;
            }

            .payment-step.active {
                display: block;
            }

            .payment-option {
                cursor: pointer;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .payment-option:hover {
                transform: translateY(-2px);
                transform: scale(1.05);
            }

            .payment-option.selected {
                border-color: var(--bs-primary);
                background-color: var(--bs-primary-bg-subtle);
                box-shadow: var(--bs-box-shadow);
                transform: scale(1.05);
            }

            .payment-option input[type="radio"] {
                position: absolute;
                opacity: 0;
            }

            .payment-logo {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
            }

            .payment-logo img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }

            .btn-pay {
                min-height: 48px;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .spinner {
                display: none;
                width: 1.5rem;
                height: 1.5rem;
                border: 2px solid #fff;
                border-top-color: transparent;
                border-radius: 50%;
                animation: spin 0.6s linear infinite;
            }

            .btn-pay.loading .spinner {
                display: inline-block;
            }

            .btn-pay.loading .btn-text {
                display: none;
            }

            .progress {
                height: 4px;
            }

            .step-indicator {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: var(--bs-gray-200);
                color: var(--bs-gray-600);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
            }

            .step-indicator.active {
                background: var(--bs-primary);
                color: white;
            }

            .step-indicator.completed {
                background: var(--bs-success);
                color: white;
            }

            .payment-confirmation {
                max-width: 320px;
                margin: 0 auto;
            }

            .confirmation-check {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: var(--bs-success);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                margin: 0 auto 1.5rem;
            }
        </style>
    @endpush
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <div class="container">
                    <div class="row justify-content-center">
                        <!-- Progress Bar -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-center">
                                        <div class="step-indicator active" id="step1">1</div>
                                        <small class="mt-1 d-block">Method</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="step-indicator" id="step2">2</div>
                                        <small class="mt-1 d-block">Details</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="step-indicator" id="step3">3</div>
                                        <small class="mt-1 d-block">Confirm</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="step-indicator" id="step4">4</div>
                                        <small class="mt-1 d-block">Complete</small>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Steps -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <form action="{{ route('paiements.store') }}" method="POST" id="payment-form">
                                    @csrf
                                    <input type="hidden" name="tarif_id" value="{{ $tarif->id }}">
                                    <!-- Step 1: Payment Method Selection -->
                                    <div class="payment-step active" id="payment-step-1">
                                        <div class="text-center mb-4">
                                            <h4 class="mb-1">Sélectionnez le mode de paiement</h4>
                                            <div class="display-4 fw-bold text-primary mb-2">{{ $tarif->prix->format() }}
                                                {{ $tarif->prix->rate }}</div>
                                            <p class="text-muted mb-0">Choisissez votre mode de paiement préféré</p>
                                        </div>

                                        <div class="row g-3">
                                            <!-- Wave -->
                                            <div class="col-md-6">
                                                <label class="payment-option card h-100 p-3" for="wave">
                                                    <input type="radio" name="payment-method" id="wave"
                                                        value="wave" required>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="payment-logo bg-primary bg-opacity-10">
                                                            <img src="{{ asset('assets/images/payments/wave.png') }}"
                                                                alt="Wave" aria-hidden="true">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Wave</h6>
                                                            <small class="text-muted">Pay with Wave Money</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Orange Money -->
                                            <div class="col-md-6">
                                                <label class="payment-option card h-100 p-3" for="orange-money">
                                                    <input type="radio" name="payment-method" id="orange-money"
                                                        value="orange-money">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="payment-logo bg-warning bg-opacity-10">
                                                            <img src="{{ asset('assets/images/payments/orange-money.png') }}"
                                                                alt="Orange Money" aria-hidden="true">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Orange Money</h6>
                                                            <small class="text-muted">Pay with Orange Money</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Stripe -->
                                            <div class="col-md-6">
                                                <label class="payment-option card h-100 p-3" for="stripe">
                                                    <input type="radio" name="payment-method" id="stripe"
                                                        value="stripe">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="payment-logo bg-info bg-opacity-10">
                                                            <img src="{{ asset('assets/images/payments/stripe.png') }}"
                                                                alt="Stripe" aria-hidden="true">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Stripe</h6>
                                                            <small class="text-muted">Pay with Credit Card</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- PayPal -->
                                            <div class="col-md-6">
                                                <label class="payment-option card h-100 p-3" for="paypal">
                                                    <input type="radio" name="payment-method" id="paypal"
                                                        value="paypal">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="payment-logo bg-primary bg-opacity-10">
                                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg"
                                                                alt="PayPal" aria-hidden="true">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">PayPal</h6>
                                                            <small class="text-muted">Pay with PayPal</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="button" class="btn btn-primary w-100 btn-lg"
                                                onclick="nextStep(2)">Continue</button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Payment Details -->
                                    <div class="payment-step" id="payment-step-2">
                                        <!-- Stripe Form -->
                                        <div class="payment-form" id="stripe-form" style="display: none;">
                                            @include('pages.paiements.stripe')
                                        </div>

                                        <!-- PayPal Form -->
                                        <div class="payment-form" id="paypal-form" style="display: none;">
                                            @include('pages.paiements.paypal')
                                        </div>

                                        <!-- Orange Money Form -->
                                        <div class="payment-form" id="orange-money-form" style="display: none;">
                                            @include('pages.paiements.orange-money')
                                        </div>
                                        <!-- Wave Money Form -->
                                        <div class="payment-form" id="wave-form" style="display: none;">
                                            @include('pages.paiements.wave')
                                        </div>


                                        <div class="d-flex gap-2 mt-4">
                                            <button type="button" class="btn btn-light btn-lg flex-grow-1"
                                                onclick="prevStep()">Back</button>
                                            <button type="button" class="btn btn-primary btn-lg flex-grow-1"
                                                onclick="nextStep(3)">Continue</button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Confirmation -->
                                    <div class="payment-step" id="payment-step-3">

                                        <input type="hidden" name="tarif_id" value="{{ $tarif->id }}" required>
                                        <div class="text-center mb-4">
                                            <h4 class="mb-1">Confirm Payment</h4>
                                            <p class="text-muted mb-0">Please review your payment details</p>
                                        </div>

                                        <div class="card bg-light border-0 mb-4">
                                            <div class="card-body">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-4">Montant:</dt>
                                                    <dd class="col-sm-8">{{ $tarif->prix->format() }}
                                                        {{ $tarif->prix->rate->symbol }}</dd>

                                                    <dt class="col-sm-4">Mode de paiement:</dt>
                                                    <dd class="col-sm-8" id="confirm-payment-method">-</dd>

                                                    <dt class="col-sm-4">Téléphone/Carte:</dt>
                                                    <dd class="col-sm-8" id="confirm-payment-detail">-</dd>
                                                </dl>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-light btn-lg flex-grow-1"
                                                onclick="prevStep()">Back</button>
                                            <button type="button" class="btn btn-primary btn-lg flex-grow-1"
                                                onclick="processPayment()">
                                                <span class="spinner"></span>
                                                <span class="btn-text">Confirm Payment</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 4: Success -->
                                    <div class="payment-step" id="payment-step-4">
                                        <div class="payment-confirmation text-center">
                                            <div class="confirmation-check">
                                                <i class="bi bi-check-lg"></i>
                                            </div>
                                            <h4 class="mb-2">Payment Successful!</h4>
                                            <p class="text-muted mb-4">Your transaction has been completed successfully</p>
                                            <div class="card bg-light border-0 mb-4">
                                                <div class="card-body">
                                                    <dl class="row mb-0">
                                                        <dt class="col-6 text-start">Amount:</dt>
                                                        <dd class="col-6 text-end">{{ $tarif->prix->format() }}
                                                            {{ $tarif->prix->rate }}</dd>

                                                        <dt class="col-6 text-start">Transaction ID:</dt>
                                                        <dd class="col-6 text-end">TXN123456</dd>

                                                        <dt class="col-6 text-start">Date:</dt>
                                                        <dd class="col-6 text-end">-</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary w-100"
                                                onclick="window.location.reload()">Done</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                @include('pages.tarifs.view')
                <div class="d-grid text-uppercase mt-4">
                    <a href="{{ url('/#tarifs') }}" class="btn btn-{{ $tarif->parametre['color'] ?? 'secondary' }}"><i
                            class="bi bi-arrow-left"></i><span class="ms-2">CHANGER DE TARIF</span></a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            let currentStep = 1;
            let selectedMethod = '';

            document.addEventListener('DOMContentLoaded', function() {
                const paymentOptions = document.querySelectorAll('.payment-option');

                // Payment option selection
                paymentOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        paymentOptions.forEach(opt => opt.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedMethod = this.querySelector('input[type="radio"]').value;

                        // Show corresponding form in step 2
                        document.querySelectorAll('.payment-form').forEach(form => {
                            form.style.display = 'none';
                        });
                        document.getElementById(selectedMethod + '-form').style.display = 'block';
                    });
                });
            });

            function nextStep(step) {
                // Validation for step 1
                if (currentStep === 1 && !selectedMethod) {
                    alert('Please select a payment method');
                    return;
                }

                // Validation for step 2
                if (currentStep === 2) {
                    const form = document.querySelector(`#${selectedMethod}-form form`);
                    if (form && !form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }

                    // Update confirmation details
                    document.getElementById('confirm-payment-method').textContent =
                        document.querySelector(`label[for="${selectedMethod}"] h6`).textContent;

                    const paymentDetail = form ? form.querySelector('input').value : 'PayPal Account';
                    document.getElementById('confirm-payment-detail').textContent = paymentDetail;
                }

                // Update progress
                document.getElementById(`step${currentStep}`).classList.add('completed');
                document.getElementById(`step${step}`).classList.add('active');
                document.querySelector('.progress-bar').style.width = (step * 25) + '%';

                // Show new step
                document.getElementById(`payment-step-${currentStep}`).classList.remove('active');
                document.getElementById(`payment-step-${step}`).classList.add('active');

                currentStep = step;
            }

            function prevStep() {
                const prevStep = currentStep - 1;

                // Update progress
                document.getElementById(`step${currentStep}`).classList.remove('active');
                document.getElementById(`step${prevStep}`).classList.remove('completed');
                document.getElementById(`step${prevStep}`).classList.add('active');
                document.querySelector('.progress-bar').style.width = (prevStep * 25) + '%';

                // Show previous step
                document.getElementById(`payment-step-${currentStep}`).classList.remove('active');
                document.getElementById(`payment-step-${prevStep}`).classList.add('active');

                currentStep = prevStep;
            }

            function processPayment() {
                const confirmBtn = document.querySelector('#payment-step-3 .btn-primary');
                confirmBtn.classList.add('loading');
                confirmBtn.disabled = true;

                document.getElementById('payment-form').submit();
            }
        </script>
    @endpush
@endsection
