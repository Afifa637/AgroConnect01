@extends('home.headerFooter')

@section('title','Contact')

@section('body')
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold text-success">📩 Contact Us</h2>

  @if(session('contact_success'))
    <div class="alert alert-success text-center shadow-sm">{{ session('contact_success') }}</div>
  @endif

  <div class="row g-4">
    <!-- Contact Form -->
    <div class="col-lg-7">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
          <h4 class="mb-3 text-success"><i class="fa fa-envelope"></i> Send Us a Message</h4>
          <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-semibold">Name</label>
              <input name="name" value="{{ old('name') }}" class="form-control shadow-sm" required>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control shadow-sm" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input name="phone" value="{{ old('phone') }}" class="form-control shadow-sm">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Subject</label>
              <input name="subject" value="{{ old('subject') }}" class="form-control shadow-sm" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Message</label>
              <textarea name="message" rows="5" class="form-control shadow-sm" required>{{ old('message') }}</textarea>
            </div>
            <button class="btn btn-success w-100 shadow-sm rounded-pill">Send Message</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Contact Info + Map -->
    <div class="col-lg-5">
      <div class="card shadow-lg border-0 rounded-3 mb-4">
        <div class="card-body">
          <h4 class="text-success"><i class="fa fa-info-circle"></i> Contact Info</h4>
          <p><i class="fa fa-map-marker-alt text-danger me-2"></i> House #100, Uttara, Dhaka</p>
          <p><i class="fa fa-envelope text-primary me-2"></i> agroconnect@gmail.com</p>
          <p><i class="fa fa-phone text-success me-2"></i> +8801625738164</p>
        </div>
      </div>

      <!-- Map -->
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
          <h5 class="mb-3 text-success"><i class="fa fa-map"></i> Find Us</h5>
          <div class="ratio ratio-4x3 rounded shadow-sm">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18..."
              style="border:0; border-radius:12px;" 
              allowfullscreen 
              loading="lazy">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
