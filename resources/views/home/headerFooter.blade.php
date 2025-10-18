<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect')</title>

    <!-- Bootstrap + Icons -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-2">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
                <img src="{{ asset('final_eagri/img/agri.png') }}" alt="AgroConnect"> AgroConnect
            </a>

            <form class="position-relative d-none d-md-flex mx-auto w-50" id="main-search" role="search"
                action="{{ route('search') }}" method="get" autocomplete="off">
                <input name="search" id="search-input" class="form-control rounded-pill border-success pe-5"
                    placeholder="Search crops, locations, farmers..." aria-label="Search">
                <button class="btn favorite-btn position-absolute end-0 top-50 translate-middle-y me-1" type="submit"
                    aria-label="Search">
                    <i class="fas fa-search text-success"></i>
                </button>

                <div id="search-suggestions" class="search-suggestion d-none"></div>
            </form>

            <div>
                @if (Session::get('c_username'))
                    <a href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}"
                        class="btn btn-outline-success me-2"><i class="far fa-heart"></i></a>
                    <div class="dropdown d-inline">
                        <button class="btn btn-success dropdown-toggle rounded-pill" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> {{ Session::get('c_username') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item"
                                    href="{{ route('cust_profile', ['c_username' => Session::get('c_username')]) }}"><i
                                        class="fa fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}"><i
                                        class="fas fa-box"></i> Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('c_settings') }}"><i class="fas fa-cog"></i>
                                    Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('buyer.logout') }}" method="POST">@csrf
                                    <button type="submit" class="dropdown-item text-danger"><i
                                            class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Login</a>
                    <a href="{{ route('signup') }}" class="btn btn-success">Signup</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Secondary Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mt-5 pt-3 shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto text-uppercase fw-semibold">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-3">Home</a></li>
                    <li class="nav-item"><a href="{{ route('about') }}" class="nav-link px-3">About</a></li>
                    <li class="nav-item"><a href="{{ route('services') }}" class="nav-link px-3">Services</a></li>
                    <li class="nav-item"><a href="{{ route('news_info') }}" class="nav-link px-3">News</a></li>
                    <li class="nav-item"><a href="{{ route('gallery') }}" class="nav-link px-3">Gallery</a></li>
                    <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link px-3">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Body -->
    <div class="container-fluid mt-5 pt-3">
        <div class="row">
            <aside class="col-lg-2 mb-4">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white fw-bold text-center">Categories</div>
                    <ul class="list-group list-group-flush">
                        @foreach (App\Models\categories_info::where('categories_status', 1)->get() as $categorie)
                            <li class="list-group-item">
                                <a href="{{ route('categories', ['crop_type' => $categorie->id]) }}"
                                    class="text-success text-decoration-none fw-semibold">
                                    {{ $categorie->categories_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <main class="col-lg-10">
                @yield('body')
            </main>
        </div>
    </div>

    <!-- Footer (upgraded, agro-themed) -->
    <footer id="site-footer" class="pt-5" role="contentinfo" aria-label="Site Footer">
        <div class="container">
            <div class="row g-4 align-items-start">
                <!-- About -->
                <div class="col-md-4">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
                        <img src="{{ asset('final_eagri/img/agri.png') }}" alt="AgroConnect"
                            style="height:44px;width:auto;margin-right:10px;">
                        <span class="h5 mb-0 fw-bold text-success">AgroConnect</span>
                    </a>
                    <p class="text-muted small mb-2">Empowering sustainable agriculture through direct connections
                        between farmers and buyers. Fair pricing • Secure bidding • Verified partners.</p>

                    <div class="d-flex gap-2 mt-3">
                        <a class="btn btn-outline-light btn-sm" href="#" aria-label="Facebook"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-sm" href="#" aria-label="YouTube"><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-sm" href="#" aria-label="Instagram"><i
                                class="fab fa-instagram"></i></a>
                    </div>

                    <div class="mt-4">
                        <div class="small text-muted mb-1">We accept</div>
                        <div class="d-flex gap-2 align-items-center">
                            <!-- simple placeholders for payment icons -->
                            <div class="p-2 bg-white rounded shadow-sm"><small class="fw-semibold">bKash</small></div>
                            <div class="p-2 bg-white rounded shadow-sm"><small class="fw-semibold">Nagad</small></div>
                            <div class="p-2 bg-white rounded shadow-sm"><small class="fw-semibold">Bank</small></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-2">
                    <h6 class="text-success fw-bold">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-muted text-decoration-none">About</a></li>
                        <li><a href="{{ route('services') }}" class="text-muted text-decoration-none">Services</a>
                        </li>
                        <li><a href="{{ route('news_info') }}" class="text-muted text-decoration-none">News</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-muted text-decoration-none">Gallery</a></li>
                        <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h6 class="text-success fw-bold">Contact</h6>
                    <address class="small text-muted mb-2">
                        Email: <a class="text-muted" href="mailto:agroconnect@gmail.com">agroconnect@gmail.com</a><br>
                        Phone: <a class="text-muted" href="tel:+8801625738164">+8801625738164</a><br>
                        Dhaka, Bangladesh
                    </address>

                    <div class="small text-muted">Support</div>
                    <a href="{{ route('contact') }}" class="btn btn-outline-success btn-sm mt-2">Get Help</a>
                </div>

                <!-- Newsletter -->
                <div class="col-md-3">
                    <h6 class="text-success fw-bold">Subscribe</h6>
                    <p class="small text-muted">Get monthly updates, crop tips and market alerts. No spam — unsubscribe
                        any time.</p>

                    <form id="footer-subscribe" class="d-flex gap-2" aria-label="Subscribe to newsletter">
                        @csrf
                        <input id="footer-subscribe-email" type="email" name="email"
                            class="form-control form-control-sm" placeholder="you@example.com"
                            aria-label="Your email" required>
                        <button id="footer-subscribe-button" class="btn btn-success btn-sm"
                            type="submit">Subscribe</button>
                    </form>

                    <div id="footer-subscribe-msg" class="small mt-2" aria-live="polite" style="min-height:1.2rem;">
                    </div>
                </div>
            </div>

            <hr class="my-4 border-2">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="small text-muted">© {{ now()->year }} AgroConnect 🌾 — Built for farmers and buyers.
                </div>
                <div class="small text-muted">Terms • Privacy • <a href="{{ route('contact') }}"
                        class="text-decoration-none">Support</a></div>
            </div>
            <div class="mt-2">
              <a href="{{ route('admin.login.page') }}" class="text-secondary text-decoration-none small">
                  Admin Login
              </a>
          </div>
        </div>
    </footer>

    <!-- ===== WhatsApp Floating Chat Popup (ONE copy only) ===== -->
    <div id="whatsapp-chat-container" aria-live="polite">
        <button id="whatsapp-button" class="shadow-lg" aria-label="Open WhatsApp chat" type="button">
            <i id="whatsapp-icon" class="fab fa-whatsapp" aria-hidden="true"></i>
        </button>

        <div id="whatsapp-popup" class="shadow-lg" role="dialog" aria-modal="false" aria-hidden="true">
            <div
                class="popup-header bg-success text-white d-flex justify-content-between align-items-center p-2 rounded-top">
                <div class="d-flex align-items-center gap-2">
                    <img src="https://via.placeholder.com/36?text=A" alt="AgroConnect"
                        style="border-radius:50%;width:36px;height:36px">
                    <div>
                        <div style="font-weight:600">AgroConnect</div>
                        <div class="small">Usually replies within a few hours</div>
                    </div>
                </div>
                <button class="btn-close btn-close-white btn-sm" id="close-popup" aria-label="Close chat"></button>
            </div>

            <div class="popup-body p-3">
                <p class="small text-muted mb-2">👋 Hi! Type your message and press Send — WhatsApp will open in a new
                    tab.</p>
                <textarea id="whatsapp-message" class="form-control mb-2" rows="3" placeholder="Type your message..."></textarea>
                <button id="send-whatsapp" class="btn btn-success w-100" type="button">
                    <i class="fab fa-whatsapp"></i> Send Message
                </button>
            </div>
        </div>
    </div>
    <style>
        :root {
            --agro-green: #198754;
            --agro-dark: #0f1720;
            --muted: #6b7280;
        }
        body {
            font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: #f6f8f9;
            color: #222;
            margin: 0;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            font-size: .95rem;
        }
        .navbar-brand img {
            height: 44px;
            width: auto;
            margin-right: 8px;
        }
        .card-ghost {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.90));
        }
        .btn-success {
            background: var(--agro-green);
            border: none;
        }
        .btn-outline-success {
            border-color: var(--agro-green);
            color: var(--agro-green);
        }
        .hero-overlay {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.45));
        }
        .favorite-btn {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 999px;
            padding: 6px 9px;
        }
        .crop-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        @media (max-width: 768px) {
            .crop-card img {
                height: 140px;
            }
        }
        #main-search {
            overflow: visible !important;
        }
        #search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.12);
            border-top: none;
            border-radius: 0 0 15px 15px;
            z-index: 1200;
            box-shadow: 0 6px 18px rgba(23, 23, 23, 0.06);
            max-height: 300px;
            overflow-y: auto;
        }
        #search-suggestions a,
        #search-suggestions div {
            display: block;
            padding: 10px 12px;
            color: #111;
            text-decoration: none;
            cursor: pointer;
        }
        #search-suggestions a:hover,
        #search-suggestions div:hover {
            background: #f6f9f6;
        }
        #whatsapp-button {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            cursor: pointer;
            z-index: 1300;
            border: none;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        #whatsapp-button:active {
            transform: scale(.98);
        }
        #whatsapp-button:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 18px rgba(0, 0, 0, .16);
        }
        #whatsapp-popup {
            display: none;
            position: fixed;
            right: 20px;
            bottom: 90px;
            width: 320px;
            max-width: calc(100% - 40px);
            background: #fff;
            border-radius: 12px;
            z-index: 1301;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
            animation: popIn .18s ease;
            overflow: hidden;
        }
        @keyframes popIn {
            from {
                transform: translateY(6px) scale(.98);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }
        .popup-header {
            gap: .5rem;
        }
        .popup-body {
            background: #fff;
        }
        #whatsapp-message {
            resize: none;
            font-size: 14px;
        }
        @media (max-width: 480px) {
            #whatsapp-popup {
                right: 10px;
                bottom: 76px;
                width: 92%;
            }
            #whatsapp-button {
                right: 10px;
                bottom: 10px;
            }
        }
        #site-footer {
            background: linear-gradient(180deg, rgba(25, 135, 84, 0.04), rgba(25, 135, 84, 0.02));
            padding: 3rem 0 2.5rem;
            color: #1f2937;
            font-size: .95rem;
        }
        #site-footer a {
            color: inherit;
            text-decoration: none;
        }
        #site-footer a:hover {
            color: var(--agro-green);
            text-decoration: underline;
        }
        #site-footer .text-success {
            color: var(--agro-green) !important;
        }
        #site-footer .btn-outline-light {
            color: rgba(0, 0, 0, 0.65);
            border-color: rgba(0, 0, 0, 0.06);
            background: rgba(255, 255, 255, 0.9);
        }
        #site-footer .btn-outline-light:hover {
            background: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(25, 135, 84, 0.06);
        }
        #footer-subscribe input.form-control {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }
        #footer-subscribe button {
            white-space: nowrap;
        }
        #site-footer .small.text-muted {
            color: #55606a;
        }
        @media (max-width: 767px) {
            #site-footer {
                padding-top: 2rem;
            }
            #site-footer .row>div {
                text-align: left;
            }
        }
        #site-footer .col-md-4,
        #site-footer .col-md-3,
        #site-footer .col-md-2 {}
        a:focus,
        button:focus,
        input:focus,
        textarea:focus {
            outline: 3px solid rgba(25, 135, 84, 0.12);
            outline-offset: 2px;
        }
    </style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Search Autocomplete (debounced)
      const input = document.getElementById('search-input');
      const suggBox = document.getElementById('search-suggestions');
      let timer = null;
      if (input) {
          input.addEventListener('input', (e) => {
              const q = e.target.value.trim();
              clearTimeout(timer);
              if (!q) {
                  suggBox.classList.add('d-none');
                  return;
              }
              timer = setTimeout(async () => {
                  try {
                      const res = await fetch(
                          "{{ route('search.autocomplete') }}?query=" +
                          encodeURIComponent(q));
                      if (!res.ok) throw new Error('Network error');
                      const json = await res.json();
                      if (!json.length) {
                          suggBox.innerHTML =
                              '<div class="p-2 text-muted">No suggestions</div>';
                          suggBox.classList.remove('d-none');
                          return;
                      }
                      suggBox.innerHTML = json.map(x =>
                          `<a href="{{ url('search') }}?search=${encodeURIComponent(x)}" class="d-block p-2 text-decoration-none text-dark">${x}</a>`
                      ).join('');
                      suggBox.classList.remove('d-none');
                  } catch (err) {
                      console.error(err);
                  }
              }, 250);
          });
          document.addEventListener('click', (ev) => {
              if (!document.getElementById('main-search').contains(ev.target)) {
                  suggBox.classList.add('d-none');
              }
          });
      }

      const whatsappButton = document.getElementById('whatsapp-button');
      const whatsappPopup = document.getElementById('whatsapp-popup');
      const closePopup = document.getElementById('close-popup');
      const sendBtn = document.getElementById('send-whatsapp');
      const msgBox = document.getElementById('whatsapp-message');
      const phone = '8801625738164';

      whatsappButton && whatsappButton.addEventListener('click', () => whatsappPopup.style.display = 'block');
      closePopup && closePopup.addEventListener('click', () => whatsappPopup.style.display = 'none');
      sendBtn && sendBtn.addEventListener('click', () => {
          const message = encodeURIComponent((msgBox.value || '').trim() ||
              'Hello AgroConnect, I need help...');
          window.open(`https://wa.me/${phone}?text=${message}`, '_blank', 'noopener');
          msgBox.value = '';
          whatsappPopup.style.display = 'none';
      });
      if (window.GLightbox) GLightbox({
          selector: '.glightbox'
      });
  });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
