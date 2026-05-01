@extends('layouts.shell')

@section('class', 'app__shell--blank')

@section('content')
    <main id="page" class="page page--centered">
        @include($page)
    </main>
    <footer class="footer">
        <div class="debugbar">
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
@endsection
