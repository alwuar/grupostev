@push('scss')
    @vite(['resources/scss/app.scss', 'resources/scss/welcome.scss', 'resources/js/app.js'])
@endpush

<x-layouts.guest>
    <div class="container">
        <h1>Titulo</h1>
    <p>parrafo</p> <span>span</span>
    </div>
</x-layouts.guest>