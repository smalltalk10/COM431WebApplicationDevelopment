<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name', 'Laravel')}}</title>
        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <!-- Table headings and body -->
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12 card-header text-center font-weight-bold">
                    <h1>{{ __('Review/Approve Potential Comments') }}</h2>
                </div>
                <div id="message"></div>
                <div class="col-md-12">
                    <table id="Table1" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Author</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Effect</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of table headings and body -->
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="{{asset('js/review-control.js')}}"></script>
    </body>
</x-app-layout>
