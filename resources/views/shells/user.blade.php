@pwaDeclareShell(modifier: 'user')

<header>
    <nav>
        <a @pwaLink(route('web'))>
            <h1>{{ config('app.name') }}</h1>
        </a>
        <ul>
            <li><a @pwaLink(route('web.about'))>About</a></li>
            <li><a @pwaLink(route('web.posts'))>Posts</a></li>
            <li><a @pwaLink(route('web.posts.new'))>New Post</a></li>
            <li><a @pwaLink(route('web.login'))>Login</a></li>
            <li><a @pwaLink(route('web.account'))>Account</a></li>
            <li><a @pwaLink(route('web.logout'))>Logout</a></li>
        </ul>
    </nav>
</header>
<main class="app__page">{!! $content !!}</main>
<footer>
    <p>This is the <strong>user</strong> shell from {{ date('H:i:s') }}.</p>
</footer>
