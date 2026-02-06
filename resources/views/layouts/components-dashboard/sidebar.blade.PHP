<aside id="layout-menu"
       class="layout-menu menu-vertical menu bg-light border-end-0 shadow"
       style="width:280px; display:flex; flex-direction:column;">

    {{-- ================= BRAND / LOGO ================= --}}
    <div class="sidebar-brand">
        <a href="{{ route('dashboard.index') }}" class="brand-link">
            <div class="brand-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <div class="brand-text">
                <span class="brand-title">TK</span>
                <span class="brand-subtitle">TRANS KEUANGAN</span>
            </div>
        </a>
    </div>

    {{-- ================= MENU ================= --}}
    <ul class="menu-inner px-3 pt-4" style="flex:1">

        <li class="menu-item mb-2 {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-grid-alt fs-4"></i>
                <span>Overview</span>
            </a>
        </li>

        <li class="menu-item mb-2 {{ Request::is('dashboard/transaksi*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.transaksi.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-transfer-alt fs-4"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="menu-header small text-uppercase my-4">
            <span class="menu-header-text">Management</span>
        </li>

        <li class="menu-item mb-2 {{ Request::is('dashboard/kategori-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-category fs-4"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li class="menu-item mb-2 {{ Request::is('dashboard/akun-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.akun-keuangan.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-credit-card fs-4"></i>
                <span>Akun / Rekening</span>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/users*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-user-circle fs-4"></i>
                <span>Manajemen User</span>
            </a>
        </li>
    </ul>

    {{-- ================= USER CARD ================= --}}
    <div class="sidebar-user">
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="user-meta">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role {{ Auth::user()->role }}">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- ================= STYLE ================= --}}
<style>
/* BRAND */
.sidebar-brand {
    height:120px;
    margin:0 16px 10px;
    border-radius:0 0 28px 0;
    background:linear-gradient(135deg,#6366f1,#7c3aed);
    box-shadow:0 20px 40px rgba(99,102,241,.35);
    display:flex;
    align-items:center;
}
.brand-link {
    display:flex;
    align-items:center;
    gap:16px;
    padding:24px;
    color:#fff;
    text-decoration:none;
}
.brand-icon {
    width:52px;
    height:52px;
    border-radius:16px;
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(6px);
    display:flex;
    align-items:center;
    justify-content:center;
}
.brand-text {
    display:flex;
    flex-direction:column;
}
.brand-title {
    font-size:22px;
    font-weight:800;
    letter-spacing:1px;
}
.brand-subtitle {
    font-size:11px;
    letter-spacing:3px;
    opacity:.85;
}

/* MENU */
.menu-link {
    color:#64748b!important;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:12px;
    transition:.25s ease;
}
.menu-link:hover {
    background:#f8fafc!important;
    transform:translateX(6px);
}
.menu-item.active>.menu-link {
    background:#5544ff!important;
    color:#fff!important;
    box-shadow:0 10px 25px rgba(85,68,255,.4);
}
.menu-item.active i {
    color:#fff!important;
}
.menu-header-text {
    font-size:.7rem;
    letter-spacing:.18em;
    color:#94a3b8;
    font-weight:700;
}

/* USER CARD */
.sidebar-user {
    margin:20px;
    padding:18px;
    border-radius:20px;
    background:#fff;
    box-shadow:0 20px 40px rgba(0,0,0,.08);
}
.user-info {
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:16px;
}
.user-avatar {
    width:48px;
    height:48px;
    border-radius:14px;
    background:linear-gradient(135deg,#6366f1,#7c3aed);
    color:#fff;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}
.user-meta {
    display:flex;
    flex-direction:column;
}
.user-name {
    font-weight:600;
    font-size:14px;
}
.user-role {
    font-size:11px;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#6366f1;
}

/* LOGOUT */
.btn-logout {
    width:100%;
    padding:12px;
    border-radius:14px;
    border:none;
    background:#f1f5f9;
    color:#ef4444;
    font-weight:600;
    transition:.25s ease;
}
.btn-logout:hover {
    background:#ef4444;
    color:#fff;
    transform:translateY(-2px);
}
</style>
