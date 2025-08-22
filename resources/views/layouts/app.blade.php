<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','MyShop')</title>

  {{-- Font + Icons --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      /* Light theme */
      --bg: #f6f7fb;
      --card: #ffffff;
      --text: #1c2430;
      --muted: #6b7280;
      --line: #e8ecf3;
      --brand: #5468ff;       /* indigo */
      --brand-2: #06b6d4;     /* teal */
      --accent: #0f172a;
      --ok: #10b981;
      --warn: #f59e0b;
      --danger: #ef4444;

      --shadow-1: 0 10px 24px rgba(29,45,78,.06);
      --shadow-2: 0 20px 45px rgba(33,41,75,.08);

      --r: 16px; --r-md: 14px; --r-sm: 12px;
      --fs-1: clamp(28px, 2.2vw, 34px);
      --fs-2: clamp(20px, 1.6vw, 24px);
      --fs-3: 18px; --fs-4: 15px;
    }

    /* Dark theme overrides */
    [data-theme="dark"]{
      --bg:#0b1220; --card:#0f172a; --text:#e5e7eb; --muted:#94a3b8; --line:#1f2a44; --accent:#e2e8f0;
      --shadow-1: 0 10px 24px rgba(0,0,0,.35);
      --shadow-2: 0 22px 48px rgba(0,0,0,.45);
    }

    *{box-sizing:border-box} html,body{height:100%}
    body{
      margin:0; background: var(--bg); color: var(--text);
      font-family: "Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      line-height: 1.5;
    }
    .container{max-width:1200px;margin-inline:auto;padding:24px}

    /* Navbar */
    .nav{
      position: sticky; top:0; z-index:50;
      backdrop-filter: blur(10px);
      background: color-mix(in oklab, var(--card), transparent 20%);
      border-bottom: 1px solid var(--line);
      transition: box-shadow .2s ease, background .2s ease;
    }
    .nav.scrolled{ box-shadow: var(--shadow-1); background: color-mix(in oklab, var(--card), transparent 8%); }
    .nav-inner{max-width:1200px;margin:auto;display:flex;align-items:center;gap:16px;padding:14px 24px}
    .brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--accent);font-weight:800;letter-spacing:.2px}
    .brand i{font-size:22px;color:var(--brand)}
    .nav-links{margin-left:auto;display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .link{color:var(--accent);text-decoration:none;padding:8px 12px;border-radius:10px}
    .link:hover{background: color-mix(in oklab, var(--brand) 10%, transparent)}
    .link.active{background: color-mix(in oklab, var(--brand) 18%, transparent); color:#fff}

    .btn{
      border:1px solid transparent; border-radius:12px; padding:10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      transition: .15s ease; display:inline-flex; align-items:center; gap:8px;
    }
    .btn:focus{outline:3px solid color-mix(in oklab, var(--brand) 40%, white); outline-offset:2px}
    .btn-brand{ background: linear-gradient(135deg, var(--brand), var(--brand-2)); color:white; box-shadow: var(--shadow-1); }
    .btn-brand:hover{ transform: translateY(-1px); filter: saturate(1.05) }
    .btn-ghost{ background:var(--card); border:1px solid var(--line); color:var(--accent) }
    .btn-ghost:hover{ border-color: color-mix(in oklab, var(--line), var(--brand) 35%); transform: translateY(-1px) }

    /* Cards & headers */
    .card{ background: var(--card); border:1px solid var(--line); border-radius: var(--r); box-shadow: var(--shadow-1); }
    .card-pad{ padding:20px }
    .header{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px; }
    .title{ font-size:var(--fs-2); font-weight:800; letter-spacing:.2px }
    .muted{ color:var(--muted) }

    /* Grid list */
    .grid{display:grid; gap:16px}
    @media (min-width: 640px){ .grid{grid-template-columns: repeat(2,1fr)} }
    @media (min-width: 992px){ .grid{grid-template-columns: repeat(3,1fr)} }
    @media (min-width: 1200px){ .grid{grid-template-columns: repeat(4,1fr)} }

    .product{
      padding:16px; border-radius: var(--r-md); border:1px solid var(--line); background:var(--card);
      display:flex; flex-direction:column; gap:10px; min-height: 220px; box-shadow: var(--shadow-1);
      transition: transform .18s ease, box-shadow .18s ease;
    }
    /* Ảnh sản phẩm: cùng tỉ lệ, không lệch */
.product .thumb{
  margin:0 0 12px 0;      /* bỏ margin mặc định của <figure> */
  width:100%;
  aspect-ratio: 4 / 3;    /* đổi 1/1 nếu muốn ô vuông */
  border-radius:12px;
  overflow:hidden;
  background:#f6f8fc;
  border:1px solid var(--line);
}
.product .thumb img{
  display:block;          /* tránh khoảng trắng dưới ảnh */
  width:100%;
  height:100%;
  object-fit:cover;       /* cắt vừa khung, không méo */
  object-position:center; /* căn giữa ảnh */
}

    .product:hover{ box-shadow: var(--shadow-2); transform: translateY(-2px) }
    .chip{ padding:6px 10px; border-radius:999px; background: color-mix(in oklab, var(--brand) 8%, var(--card)); color: color-mix(in oklab, var(--brand) 65%, black); font-weight:700; font-size:13px; border:1px solid color-mix(in oklab, var(--brand) 30%, var(--line)) }
    .price{ font-weight:800; color: var(--brand); letter-spacing:.3px }

    /* Table (admin) */
    .table{ width:100%; border-collapse:separate; border-spacing:0; overflow:hidden; border-radius: var(--r); border:1px solid var(--line); background:var(--card); box-shadow: var(--shadow-1); }
    .table th, .table td{ padding:14px 16px; text-align:left; font-size: var(--fs-4) }
    .table thead th{ background: color-mix(in oklab, var(--brand) 10%, var(--card)); color: color-mix(in oklab, var(--brand) 85%, #fff); font-weight:800; border-bottom:1px solid var(--line) }
    .table tbody tr + tr td{ border-top:1px solid var(--line) }
    .table tbody tr:hover{ background: color-mix(in oklab, var(--brand) 6%, var(--card)) }

    /* Forms */
    .form{display:grid; gap:14px}
    .field label{display:block; font-weight:700; margin-bottom:6px; color: color-mix(in oklab, var(--accent), var(--brand) 20%) }
    .input, .select, .textarea{
      width:100%; border:1px solid var(--line); border-radius:12px; padding:12px 14px; background:var(--card); font:inherit; color:var(--accent);
      transition:.15s ease; box-shadow: inset 0 1px 0 rgba(0,0,0,.015);
    }
    .input:focus, .select:focus, .textarea:focus{outline: 3px solid color-mix(in oklab, var(--brand) 40%, white); border-color: color-mix(in oklab, var(--brand) 35%, var(--line)) }
    .help{font-size:13px; color:var(--muted)}
    .error{font-size:13px; color: var(--danger); margin-top:4px}

    /* Utilities */
    .row{display:flex; gap:12px; flex-wrap:wrap}
    .grow{flex:1}
    .right{margin-left:auto}
    .mt-2{margin-top:8px}.mt-3{margin-top:12px}.mt-4{margin-top:16px}.mt-6{margin-top:24px}
    .mb-2{margin-bottom:8px}.mb-3{margin-bottom:12px}.mb-4{margin-bottom:16px}.mb-6{margin-bottom:24px}
    .center{text-align:center}

    /* Footer */
    footer{border-top:1px solid var(--line); margin-top:24px}
    footer .wrap{max-width:1200px;margin:auto;padding:18px 24px;color:var(--muted);display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap}
  </style>
</head>
<body>

<header class="nav" id="topbar">
  <div class="nav-inner">
    <a class="brand" href="{{ url('/') }}"><i class="ri-sparkling-2-fill"></i><span>Comestics Alley</span></a>

    <nav class="nav-links">
      <a href="{{ route('products.index') }}"
         class="link {{ request()->routeIs('products.*') ? 'active' : '' }}">Sản phẩm</a>

      @auth
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.products.index') }}"
             class="link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Quản lý SP</a>
          <a href="{{ route('admin.categories.index') }}"
             class="link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Danh mục</a>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="right">@csrf
          <button class="btn btn-ghost"><i class="ri-logout-box-r-line"></i> Đăng xuất</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-ghost"><i class="ri-user-3-line"></i> Đăng nhập</a>
        <a href="{{ route('register.show') }}" class="btn btn-brand"><i class="ri-edit-2-line"></i> Đăng ký</a>
      @endauth

      {{-- Theme toggle --}}
      <button class="btn btn-ghost" id="themeToggle" title="Đổi giao diện" aria-label="Đổi giao diện">
        <i class="ri-contrast-2-line"></i>
      </button>
    </nav>
  </div>
</header>

<main class="container">
  @yield('content')
</main>

<footer>
  <div class="wrap">
    <span>© {{ date('Y') }} Comestics Alley</span>
    <span class="muted">Crafted with ♥ • Indigo × Teal</span>
  </div>
</footer>

<script>
  // Navbar shadow on scroll
  (function(){
    const bar = document.getElementById('topbar');
    const onScroll = () => bar.classList.toggle('scrolled', window.scrollY > 6);
    onScroll(); window.addEventListener('scroll', onScroll, {passive:true});
  })();

  // Theme toggle (persist to localStorage)
  (function(){
    const key = 'theme';
    const saved = localStorage.getItem(key);
    if(saved){ document.documentElement.setAttribute('data-theme', saved); }
    else if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
      document.documentElement.setAttribute('data-theme','dark');
    }
    document.getElementById('themeToggle').addEventListener('click', ()=>{
      const cur = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', cur);
      localStorage.setItem(key, cur);
    });
  })();

  // SweetAlert2 toast for success/error + first validation error
  @if (session('success'))
  Swal.fire({icon:'success', title:@json(session('success')), toast:true, position:'top-end', showConfirmButton:false, timer:2200, timerProgressBar:true});
  @endif
  @if (session('error'))
  Swal.fire({icon:'error', title:@json(session('error')), toast:true, position:'top-end', showConfirmButton:false, timer:2400, timerProgressBar:true});
  @endif
  @if ($errors->any())
  Swal.fire({icon:'error', title:@json($errors->first()), toast:true, position:'top-end', showConfirmButton:false, timer:2600, timerProgressBar:true});
  @endif
</script>

</body>
</html>
