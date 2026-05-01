@extends('layouts.shell')

@section('class', 'app__shell--user')

@section('content')
    <header class="header">
        <nav class="navbar">
            <a class="navbar__heading" @pwaLink(route('pwa'))>
                <h1>{{ config('app.name') }}</h1>
            </a>
            <ul class="navbar__list">
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.about'))>
                        About
                    </a>
                </li>
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.posts'))>
                        Posts
                    </a>
                </li>
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.posts.new'))>
                        New Post
                    </a>
                </li>
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.login'))>
                        Login
                    </a>
                </li>
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.account'))>
                        Account
                    </a>
                </li>
                <li class="navbar__item">
                    <a class="navbar__link" @pwaLink(route('pwa.logout'))>
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main id="page" class="page">
        @include($page)
    </main>
    <footer class="footer">
        <div class="debugbar">
            This is the <strong>user</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
@endsection
