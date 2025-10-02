@extends('home.headerFooter')

@section('title', 'Home')

@section('body')

<!-- 🌾 HERO / CAROUSEL -->
<div id="home-hero" class="mb-5">
  <div id="carouselExampleIndicators" class="carousel slide rounded shadow-sm" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active position-relative">
        <img src="{{ asset('final_eagri/img/1.jpg') }}" class="d-block w-100" alt="Slide 1">
        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-4">
          <h1 class="fw-bold text-white">Connecting Farmers & Buyers</h1>
          <p>Bringing technology and trust to agriculture trade</p>
          <a href="{{ route('signup') }}" class="btn btn-success btn-lg mt-2">Join Now</a>
        </div>
      </div>
      <div class="carousel-item position-relative">
        <img src="{{ asset('final_eagri/img/2.jpg') }}" class="d-block w-100" alt="Slide 2">
        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-4">
          <h1 class="fw-bold text-white">Empowering Farmers</h1>
          <p>Fair prices, no middlemen, more profits</p>
        </div>
      </div>
      <div class="carousel-item position-relative">
        <img src="{{ asset('final_eagri/img/3.jpg') }}" class="d-block w-100" alt="Slide 3">
        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-4">
          <h1 class="fw-bold text-white">Fresh Crops for Buyers</h1>
          <p>Access quality products directly from farms</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 🌱 ABOUT + LATEST NEWS -->
<section id="about" class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <h2 class="fw-bold text-success">About AgroConnect</h2>
        <p class="lead">We connect farmers and buyers directly — removing barriers and empowering agriculture.</p>
        <p>Our platform enables listing, bidding, and secure trade with tools tailored for farmers and buyers.</p>
        <a class="btn btn-success mt-3" href="{{ route('about') }}">Learn More</a>
      </div>
      <div class="col-lg-6">
        @if(isset($latestNews) && $latestNews->count())
          <h5 class="fw-bold mb-3">🌾 Latest News</h5>
          <div class="row g-3">
            @foreach($latestNews as $news)
              <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                  <img src="{{ url($news->news_image) }}" class="card-img-top" alt="">
                  <div class="card-body">
                    <h6 class="fw-bold">{{ Str::limit($news->news_name, 40) }}</h6>
                    <p class="small text-muted">{{ Str::limit($news->news_description, 60) }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <div class="mt-3">
            <a href="{{ route('news_info') }}" class="btn btn-outline-success btn-sm">View All News</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- 🌟 FEATURES / SERVICES -->
<section id="services" class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-4 text-center fw-bold">Our Services</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow border-0 text-center p-4">
          <i class="fas fa-seedling fa-3x text-success mb-3"></i>
          <h5 class="fw-bold">Crop Marketplace</h5>
          <p>Farmers list produce, buyers bid — transparent and fair.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow border-0 text-center p-4">
          <i class="fas fa-hand-holding-heart fa-3x text-primary mb-3"></i>
          <h5 class="fw-bold">Farmer Support</h5>
          <p>Guidance on pricing, selling, and expanding market reach.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow border-0 text-center p-4">
          <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
          <h5 class="fw-bold">Secure Bids</h5>
          <p>Safe bidding process with verified farmers and buyers.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 📊 STATS / COUNTERS -->
<section class="py-5 text-white" style="background: url('{{ asset('final_eagri/img/crop.jpg') }}') center/cover no-repeat fixed;">
  <div class="container text-center">
    <div class="row g-4">
      <div class="col-md-3">
        <h2 class="fw-bold counter" data-target="5000">0</h2>
        <p>Farmers Registered</p>
      </div>
      <div class="col-md-3">
        <h2 class="fw-bold counter" data-target="10000">0</h2>
        <p>Crops Listed</p>
      </div>
      <div class="col-md-3">
        <h2 class="fw-bold counter" data-target="3000">0</h2>
        <p>Verified Buyers</p>
      </div>
      <div class="col-md-3">
        <h2 class="fw-bold counter" data-target="15">0</h2>
        <p>Categories</p>
      </div>
    </div>
  </div>
</section>

<!-- 🗣️ TESTIMONIALS -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">What Farmers Say</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow h-100 text-center p-4">
          <p class="text-muted">"AgroConnect helped me sell directly to buyers, no middlemen, better profits!"</p>
          <h6 class="fw-bold mt-3">— Abdul, Farmer</h6>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center p-4">
          <p class="text-muted">"The platform is easy to use and transparent. I trust AgroConnect."</p>
          <h6 class="fw-bold mt-3">— Rafiq, Buyer</h6>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center p-4">
          <p class="text-muted">"I expanded my reach and found loyal customers. Highly recommend!"</p>
          <h6 class="fw-bold mt-3">— Fatema, Farmer</h6>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 📰 LATEST NEWS -->
<section id="latest-news" class="py-5">
  <div class="container">
    <h2 class="mb-4 text-center fw-bold">Latest News</h2>
    <div class="row g-4">
      @forelse($latestNews as $news)
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ url($news->news_image) }}" class="card-img-top" alt="News Image">
            <div class="card-body">
              <h6 class="fw-bold">{{ Str::limit($news->news_name, 50) }}</h6>
              <p class="small text-muted">{{ Str::limit($news->news_description, 80) }}</p>
              <a href="{{ route('news_info') }}" class="btn btn-outline-success btn-sm">Read More</a>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">No news available.</p>
      @endforelse
    </div>
    <div class="text-center mt-4">
      <a href="{{ route('news_info') }}" class="btn btn-success">View All News</a>
    </div>
  </div>
</section>

<!-- 🌟 CTA BANNER -->
<section class="py-5 text-center text-white" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('{{ asset('final_eagri/img/service.jpg') }}') center/cover fixed;">
  <div class="container">
    <h2 class="fw-bold mb-3">Join AgroConnect Today</h2>
    <p class="lead">Empower your farming journey, connect with buyers, and grow your business.</p>
    <a href="{{ route('signup') }}" class="btn btn-success btn-lg">Get Started</a>
  </div>
</section>

<!-- ✅ Counter Animation Script -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".counter");
    const speed = 150; // lower is faster

    const animateCounters = () => {
      counters.forEach(counter => {
        const updateCount = () => {
          const target = +counter.getAttribute("data-target");
          const count = +counter.innerText;

          const increment = Math.ceil(target / speed);

          if (count < target) {
            counter.innerText = count + increment;
            setTimeout(updateCount, 30);
          } else {
            counter.innerText = target.toLocaleString();
          }
        };
        updateCount();
      });
    };

    // Run animation only once when section is visible
    let executed = false;
    window.addEventListener("scroll", () => {
      const section = document.querySelector("#latest-news");
      const statsSection = document.querySelector(".counter").closest("section");
      if (!executed && statsSection.getBoundingClientRect().top < window.innerHeight) {
        animateCounters();
        executed = true;
      }
    });
  });
</script>

@endsection
