@pwaDeclareShell(modifier: 'blank')

<main id="page" class="page page--centered">{!! $content !!}</main>
<footer class="footer">
    <div class="debugbar">
        This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
    </div>
</footer>
