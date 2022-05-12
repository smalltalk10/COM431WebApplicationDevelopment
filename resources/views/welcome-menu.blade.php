<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name', 'Laravel')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                   <div class="mt-2 text-gray-600 dark:text-gray-400" style="font-size:xx-large"><b>Welcome to Niall Morrissey's (B00787301) Comment Bank Application!</b></div>
                </div>
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="ajax-restricted-comment-crud" class="underline text-gray-900 dark:text-white">View Comment Bank (read-only)</a></div>
                            </div>
                            <div class="ml-4">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                   Access read-only view of the comment bank application. Unauthenticated users can view, copy and make comment suggestions for Admins to consider. 
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="/ajax-admin-comment-crud" class="underline text-gray-900 dark:text-white">View Admin Comment Bank</a></div>
                                <div class="ml-4 text-sm leading-7 font-semibold dark:text-white" >(*Authentication Required)</div>
                            </div>
                            <div class="ml-4">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Only for authenticated administrators as requires log-in to access. Access admin view of the comment bank application full CRUD functionality and to approve suggested comments.  
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
    </body>
</html>
