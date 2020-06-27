<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/game.css">
        <script type="text/javascript" src="/js/game.js"></script>
    <head>
    <body>
        <h1 class="text-center">Move over the obstacle!!</h1>
        <div class="parent mt-40">
            <div class="corner-3 obstacle-corner" data-position="3" id="obstacle">
                
            </div>
            <div class="child corner-1" data-position="1" id="child">
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-md-5 col-lg-5">

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 controls">
                <button class="btn btn-success margin-30" onclick="move(1)">FORWARD</button>
                <button class="btn btn-success margin-30" onclick="move(-1)">REVERSE</button>
            </div>
        </div>
    </body>
</html>