<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            <example-component
            :divisions='@json($divisions)'
            :playoffs='@json($playoffs)'
            :semis='@json($semis)'
            :loser_finals='@json($loser_finals)'
            :finals='@json($finals)'
            csrf="{{csrf_token()}}"
            ></example-component>
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>
