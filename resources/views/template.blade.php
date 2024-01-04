<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('photoviewer/photoviewer.min.css') }}" rel="stylesheet" />
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    @vite('resources/css/app.css')
</head>
<body>
    @include('header')

    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.js"></script>
    <script src="{{ asset('photoviewer/photoviewer.min.js') }}"></script>

    <script>
        @if (session()->has('fail'))
        toastr.options.timeOut = 3000;        
        toastr.error('{{ session()->get('fail') }}')
        @elseif(session()->has('success'))
        toastr.options.timeOut = 3000;    
        toastr.success('{{ session()->get('success') }}')
        @endif

        $(function() {
            $('.number').number(true);

            $('.close-menu').click(function() {
                $(this).parent().parent().parent().parent().find('.fixed').css('transform', 'translateY(-100%)')
            })

            $('.open-menu').click(function() {
                $('.close-menu').parent().parent().parent().find('.fixed').css('transform', 'translateY(0)')
            })
        })
        function showReceipt(url, title) {
            const photos = [
                {
                src: url,
                title: title
                }
            ]

            new PhotoViewer(photos, {})
        }
    </script>
    @stack('scripts')
</body>
</html>