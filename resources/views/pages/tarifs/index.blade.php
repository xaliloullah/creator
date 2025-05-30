{{-- <section class="py-5 bg-light-lighten border-top border-bottom border-light" id="tarifs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1 class="mt-0"><i class="fa fa-tag-multiple"></i></h1>
                    <h3>Choose Simple <span class="text-primary">Pricing</span></h3>
                    <p class="text-muted mt-2">The clean and well commented code allows easy customization of the
                        theme.It's designed for
                        <br>describing your app, agency or business.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-3">
            @foreach ($tarifs as $tarif)
                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div
                            class="card-header bg-{{ $tarif->parametre['color'] }} py-3 align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark text-uppercase">{{ $tarif->nom }}</h6>
                        </div>
                        <div class="card-body">
                            <h2 class="">{{ $tarif->prix }}</h2>
                            {!! $tarif->description !!}
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('paiement.mode', crypter($tarif->id)) }}"
                                class="btn btn-primary mt-4 mb-2 rounded-pill">Choisir un forfait</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section> --}}
<!-- Pricing Section -->
<section class="py-5 bg-white mb-5" id="tarifs">
    <div class="container px-4">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Plans tarifaires</h2>
            <p class="lead text-muted mx-auto col-6">Choisissez le plan parfait pour vos besoins avec notre
                options de tarification flexibles.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($tarifs->sortBy('prix') as $tarif)
                <div class="col-md-6 col-lg-4">
                    @include('pages.tarifs.view')
                    <div class="d-grid text-uppercase mt-4">
                        <a href="{{ route('paiement.mode', $tarif->id) }}"
                            class="btn btn-{{ $tarif->parametre['color'] }} bg-gradient fw-bold">Commencer</a>
                    </div>
                </div>
            @endforeach
            {{-- <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="badge bg-primary mb-2">Popular</div>
                            <h4 class="mb-2">Professional</h4>
                            <h2 class="display-5 fw-bold mb-0">$99</h2>
                            <p class="text-muted">per month</p>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Unlimited Projects</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>1TB Storage</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Priority Support</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Advanced Analytics</span>
                            </li>
                        </ul>
                        <div class="d-grid">
                            <button class="btn btn-primary">Get Started</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
