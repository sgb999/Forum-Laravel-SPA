<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead

</head>
<body>
<style>
    body{
        margin: 0 !important;
        overflow-x: hidden;
    }
    .container {
        margin-top: 20px;
    }
</style>
@inertia
</body>
</html>
