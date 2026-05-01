<div id="shell" class="app__shell @yield('class', 'app__shell--default')" hx-headers='{"HX-Current-Shell": "{{ $shell }}"}'>
    @yield('content')
</div>
