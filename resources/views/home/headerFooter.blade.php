<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect')</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Theme -->
    <style>
        :root {
            --agro-green: #198754;
            --agro-dark: #1b1f1a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f7faf9;
            color: #2c2c2c;
        }

        .navbar {
            font-weight: 500;
        }

        .navbar-brand img {
            height: 42px;
        }

        .navbar-light .nav-link:hover {
            color: var(--agro-green) !important;
        }

        .btn-success {
            background: var(--agro-green);
            border: none;
        }

        .btn-outline-success:hover {
            background: var(--agro-green);
            color: #fff;
        }

        footer {
            background: var(--agro-dark);
            color: #fff;
        }

        footer a {
            color: #d4d4d4;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        #whatsapp-chat {
            transition: transform .3s ease;
        }

        #whatsapp-chat:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-2">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
                <img src="{{ asset('final_eagri/img/agri.png') }}" alt="AgroConnect"> AgroConnect
            </a>

            <form class="d-flex mx-auto" action="{{ route('search') }}" method="get">
                <input class="form-control me-2 rounded-pill border-success" type="search" name="search"
                    placeholder="Search crops..." style="min-width: 280px;">
                <button class="btn btn-success rounded-pill px-3"><i class="fas fa-search"></i></button>
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
                    <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link px-3">Contact</a></li>
                    <li class="nav-item"><a href="{{ route('gallery') }}" class="nav-link px-3">Gallery</a></li>
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

    <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container text-center text-md-start">
            <div class="row g-4">
                <div class="col-md-3">
                    <h5>About AgroConnect</h5>
                    <p>Empowering sustainable agriculture through smart connections between farmers and buyers.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('news_info') }}">News</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="me-3 text-success"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="me-3 text-danger"><i class="fab fa-youtube fa-lg"></i></a>
                    <a href="#" class="text-warning"><i class="fab fa-instagram fa-lg"></i></a>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <p>Email: agroconnect@gmail.com</p>
                    <p>Phone: +8801625738164</p>
                </div>
            </div>
            <hr>
            <p class="text-center small mb-0">&copy; {{ now()->year }} AgroConnect 🌾 All rights reserved.</p>
        </div>
    </footer>

   <!-- ===== WhatsApp Floating Chat Popup (ONE copy only) ===== -->
<div id="whatsapp-chat-container" aria-live="polite">
    <!-- Floating Button -->
    <button id="whatsapp-button" class="shadow-lg" aria-label="Open WhatsApp chat" type="button">
      <i id="whatsapp-icon" class="fab fa-whatsapp" aria-hidden="true"></i>
    </button>
  
    <!-- Chat Popup Box -->
    <div id="whatsapp-popup" class="shadow-lg" role="dialog" aria-modal="false" aria-hidden="true">
      <div class="popup-header bg-success text-white d-flex justify-content-between align-items-center p-2 rounded-top">
        <div class="d-flex align-items-center gap-2">
          <img src="https://via.placeholder.com/36?text=A" alt="AgroConnect" style="border-radius:50%;width:36px;height:36px">
          <div>
            <div style="font-weight:600">AgroConnect</div>
            <div class="small">Usually replies within a few hours</div>
          </div>
        </div>
        <button class="btn-close btn-close-white btn-sm" id="close-popup" aria-label="Close chat"></button>
      </div>
  
      <div class="popup-body p-3">
        <p class="small text-muted mb-2">👋 Hi! Type your message and press Send — WhatsApp will open in a new tab.</p>
        <textarea id="whatsapp-message" class="form-control mb-2" rows="3" placeholder="Type your message..."></textarea>
        <button id="send-whatsapp" class="btn btn-success w-100" type="button">
          <i class="fab fa-whatsapp"></i> Send Message
        </button>
      </div>
    </div>
  </div>
  
  <!-- ===== Styles ===== -->
  <style>
    /* Floating Button */
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
      z-index: 1100; /* above most site elements */
      border: none;
      transition: transform .15s ease, box-shadow .15s ease;
    }
    #whatsapp-button:active { transform: scale(.98); }
    #whatsapp-button:hover { transform: scale(1.06); box-shadow: 0 6px 18px rgba(0,0,0,.16); }
  
    /* Popup Box */
    #whatsapp-popup {
      display: none;
      position: fixed;
      right: 20px;
      bottom: 90px;
      width: 320px;
      max-width: calc(100% - 40px);
      background: #fff;
      border-radius: 12px;
      z-index: 1101;
      box-shadow: 0 8px 30px rgba(0,0,0,0.18);
      animation: popIn .18s ease;
      overflow: hidden;
    }
    @keyframes popIn {
      from { transform: translateY(6px) scale(.98); opacity: 0; }
      to   { transform: translateY(0) scale(1); opacity: 1; }
    }
  
    .popup-header { gap: .5rem; }
    .popup-body { background:#fff; }
  
    #whatsapp-message { resize: none; font-size: 14px; }
  
    @media (max-width: 480px) {
      #whatsapp-popup { right: 10px; bottom: 76px; width: 92%; }
      #whatsapp-button { right: 10px; bottom: 10px; }
    }
  </style>
  
  <!-- ===== Script (single listener, includes debug logs) ===== -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Elements
      const whatsappButton = document.getElementById('whatsapp-button');
      const whatsappIcon = document.getElementById('whatsapp-icon'); // optional
      const whatsappPopup  = document.getElementById('whatsapp-popup');
      const closePopup     = document.getElementById('close-popup');
      const sendButton     = document.getElementById('send-whatsapp');
      const messageBox     = document.getElementById('whatsapp-message');
      const phoneNumber    = '8801625738164'; // update if needed
  
      // tiny helper to show/hide
      function showPopup() {
        whatsappPopup.style.display = 'block';
        whatsappPopup.setAttribute('aria-hidden', 'false');
        messageBox.focus();
        console.log('WhatsApp popup opened');
      }
      function hidePopup() {
        whatsappPopup.style.display = 'none';
        whatsappPopup.setAttribute('aria-hidden', 'true');
        console.log('WhatsApp popup closed');
      }
  
      // debug guard: ensure elements exist
      if (!whatsappButton || !whatsappPopup || !sendButton) {
        console.error('WhatsApp chat: required DOM elements not found.');
        return;
      }
  
      // Open popup on click or touch
      whatsappButton.addEventListener('click', (e) => {
        e.stopPropagation();
        showPopup();
      });
      // also handle icon clicks (redundant but safe)
      whatsappIcon && whatsappIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        showPopup();
      });
  
      // Close popup
      closePopup.addEventListener('click', (e) => {
        e.stopPropagation();
        hidePopup();
      });
  
      // Click outside to close
      document.addEventListener('click', (ev) => {
        if (!whatsappPopup.contains(ev.target) && ev.target !== whatsappButton && !whatsappButton.contains(ev.target)) {
          if (whatsappPopup.style.display === 'block') hidePopup();
        }
      });
  
      // Press Esc to close
      document.addEventListener('keydown', (ev) => {
        if (ev.key === 'Escape' && whatsappPopup.style.display === 'block') hidePopup();
      });
  
      // Send button: open wa.me in new tab with prefilled message
      sendButton.addEventListener('click', () => {
        const message = (messageBox.value || '').trim() || 'Hello AgroConnect, I need help with...';
        const encoded = encodeURIComponent(message);
        const url = `https://wa.me/${phoneNumber}?text=${encoded}`;
        console.log('Opening WhatsApp URL:', url);
        window.open(url, '_blank', 'noopener');
        hidePopup();
        messageBox.value = '';
      });
  
      // optional: seamless UX on Enter+Ctrl to send
      messageBox.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
          e.preventDefault();
          sendButton.click();
        }
      });
  
      console.log('WhatsApp chat script initialized.');
    });
  </script>
  <!-- ===== End WhatsApp Floating Chat Popup ===== -->
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
