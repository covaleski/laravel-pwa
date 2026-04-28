@pwaDeclareShell(modifier: 'user')

<header class="header">
    <nav class="navbar">
        <a class="navbar__heading" @pwaLink(route('web'))>
            <h1>{{ config('app.name') }}</h1>
        </a>
        <ul class="navbar__list">
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.about'))>
                    About
                </a>
            </li>
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.posts'))>
                    Posts
                </a>
            </li>
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.posts.new'))>
                    New Post
                </a>
            </li>
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.login'))>
                    Login
                </a>
            </li>
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.account'))>
                    Account
                </a>
            </li>
            <li class="navbar__item">
                <a class="navbar__link" @pwaLink(route('web.logout'))>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</header>
<main id="page" class="page">{!! $content !!}</main>
<footer class="footer">
    <div class="debugbar">
        This is the <strong>user</strong> shell from {{ date('H:i:s') }}.
    </div>
</footer>
