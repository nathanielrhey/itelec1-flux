@extends('layouts.app')

@section('title', 'Contact Us — fluxPetShop')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Contact Us</h1>
        <p class="page-subtitle">Have a question, feedback, or inquiry? We'd love to hear from you.</p>
    </div>
</div>

<div class="contact-layout">

    {{-- ── Contact Form ── --}}
    <div>
        <div class="card">
            <h2 class="card-title">Send us a Message</h2>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" novalidate>
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">
                        Your Name <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name') }}"
                        placeholder="e.g. Juan dela Cruz"
                        maxlength="100"
                        autocomplete="name"
                    >
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">
                        Email Address <span class="required-star">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        maxlength="150"
                        autocomplete="email"
                    >
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="form-group">
                    <label for="subject" class="form-label">
                        Subject <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        value="{{ old('subject') }}"
                        placeholder="e.g. Product inquiry, Order question…"
                        maxlength="160"
                    >
                    @error('subject')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Message --}}
                <div class="form-group">
                    <label for="message" class="form-label">
                        Message <span class="required-star">*</span>
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"
                        placeholder="Write your message here…"
                        maxlength="3000"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                    <p class="form-hint">Minimum 10 characters. Max 3,000.</p>
                </div>

                <div class="contact-form-footer">
                    <button type="submit" class="btn btn-primary">
                        ✉ Send Message
                    </button>
                    <p class="form-hint">Fields marked <span class="required-star">*</span> are required.</p>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Info Sidebar ── --}}
    <aside class="contact-sidebar">

        <div class="card contact-info-card">
            <h2 class="card-title">Get in Touch</h2>
            <ul class="contact-info-list">
                <li>
                    <span class="contact-icon">📍</span>
                    <div>
                        <strong>Visit Us</strong>
                        <p>123 Paws Avenue, Petville, PH 1234</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon">📞</span>
                    <div>
                        <strong>Call Us</strong>
                        <p>+63 912 345 6789</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon">✉</span>
                    <div>
                        <strong>Email Us</strong>
                        <p>FluxPetShop  @Gmail.com</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon">🕐</span>
                    <div>
                        <strong>Store Hours</strong>
                        <p>Mon – Sat: 8 AM – 7 PM<br>Sunday: 9 AM – 5 PM</p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="card contact-note-card">
            <p class="contact-note-text">
                🐾 We typically respond within <strong>1–2 business days</strong>.
                For urgent order concerns, please include your reference number in the subject.
            </p>
        </div>

    </aside>

</div>

@endsection
