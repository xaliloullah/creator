@extends('index')
@section('title', 'Accueil')
@section('content')
    <!-- Hero Section -->
    <section id="home" class="vh-100 position-relative d-flex align-items-center text-white">
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; z-index: -1;">
        </div>
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Building Digital Excellence</h1>
            <p class="lead mb-4">Transform your ideas into reality with our cutting-edge solutions</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Why Choose Us</h2>
                <p class="lead text-muted">Discover what makes us different</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-rocket-takeoff text-primary fs-1 mb-3"></i>
                            <h3 class="h4 mb-3">Lightning Fast</h3>
                            <p class="text-muted">Optimized performance for the best user experience</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-check text-primary fs-1 mb-3"></i>
                            <h3 class="h4 mb-3">Secure by Design</h3>
                            <p class="text-muted">Built with security best practices from the ground up</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-lightning text-primary fs-1 mb-3"></i>
                            <h3 class="h4 mb-3">Modern Tech Stack</h3>
                            <p class="text-muted">Using the latest and most reliable technologies</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        alt="Team collaboration" class="img-fluid rounded shadow" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">About Our Company</h2>
                    <p class="lead text-muted mb-4">We're a team of passionate developers and designers dedicated to
                        creating exceptional digital experiences.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i>10+ Years Experience</li>
                        <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i>200+ Projects Completed</li>
                        <li class="mb-3"><i class="bi bi-check2-circle text-primary me-2"></i>95% Client Satisfaction</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Our Services</h2>
                <p class="lead text-muted">Comprehensive solutions for your digital needs</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-globe text-primary fs-1 mb-3"></i>
                            <h3 class="h5">Web Development</h3>
                            <p class="text-muted">Custom websites and web applications</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-phone text-primary fs-1 mb-3"></i>
                            <h3 class="h5">Mobile Apps</h3>
                            <p class="text-muted">Native and cross-platform solutions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-code-slash text-primary fs-1 mb-3"></i>
                            <h3 class="h5">API Development</h3>
                            <p class="text-muted">Robust and scalable APIs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-cloud text-primary fs-1 mb-3"></i>
                            <h3 class="h5">Cloud Solutions</h3>
                            <p class="text-muted">Secure and reliable infrastructure</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.tarifs.index')

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold">Entrer en contact</h2>
                        <p class="lead text-muted">Nous aimerions avoir de vos nouvelles</p>
                    </div>
                    <form class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" required>
                            <div class="invalid-feedback">Please provide your name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                            <div class="invalid-feedback">Please provide a message.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
