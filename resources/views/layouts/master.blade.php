<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="_token" content="{{ csrf_token() }}" />
        <link rel="icon" href="../../favicon.ico">

        <title>@yield('title')</title>

        @section('css')
            {!! Html::style(elixir('css/app.css')) !!}
            {!! Html::style('css/datatables.min.css') !!}
            {!! Html::style('http://fonts.googleapis.com/css?family=Archivo+Black') !!}
            {!! Html::style(asset('vendor/nutrition-label/nutritionLabel.css')) !!}
            {!! Html::style('css/custom.css') !!}
        @show
        </head>

        <body>
            @include('layouts.header')
            @yield('body')
            @include('layouts.footer')

            @section('js')

            {!! Html::script('js/jquery.min.js') !!}
            {!! Html::script('js/vendor/bootstrap/bootstrap.min.js') !!}
            {!! Html::script('js/angular.min.js') !!}
            {!! Html::script('js/angular-route.min.js') !!}
            {!! Html::script(asset('vendor/nutrition-label/nutritionLabel-min.js')) !!}
            {!! Html::script('js/datatables.min.js') !!}
            {!! Html::script('js/vendor/select2/select2.min.js') !!}
            {!! Html::script('js/vendor/typeahead-bootstrap/bootstrap-typeahead.min.js') !!}
            {!! Html::script('js/vendor/jquery.inputmask/jquery.inputmask.bundle.min.js') !!}
            {!! Html::script('js/vendor/parsleyjs/parsley.min.js') !!}
            {!! Html::script('js/laroute.js') !!}
            {!! Html::script(elixir('js/plugins.js')) !!}
        @show
    </body>
</html>
