<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @routes
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
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
    .filepond--credits{
        display: none
    }
</style>
@inertia
</body>
</html>
