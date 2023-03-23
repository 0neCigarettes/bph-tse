<?php
$routeName = Route::currentRouteName();
?>
<li class="menu-item {{ $routeName == 'admin.home' ? 'active' : '' }}">
    <a href="{{ route('admin.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>
<li class="menu-item {{ $routeName == 'admin.allUsers' ? 'active' : '' }}">
    <a href="{{ route('admin.allUsers') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-user-account'></i>
        <div data-i18n="Analytics">Pengguna</div>
    </a>
</li>
