<?php
$routeName = Route::currentRouteName();
?>
<li class="menu-item {{ $routeName == 'user.home' ? 'active' : '' }}">
    <a href="index.html" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>
