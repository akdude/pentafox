<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Git Users Dashboard</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/git.css">
        <link rel="stylesheet" href="/css/jquery-spinner.min.css" />
        <script src="/css/jquery-spinner.min.js"></script>
    </head>
    <body>
        <div id="spinner">
            <div class="container">
                <h2>Git Users Dashboard</h2><br><br>
                <div class="row hide" id="searchbar">
                    <div class="col-sm-9">
                        
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group float-right mb-20">
                            <input type="text" class="form-control" id="searchUsers" placeholder="Search" name="search">
                            <div class="input-group-btn">
                                <button class="btn btn-default" id="searchUsersIcon">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>        
                    </div>
                </div>
                <div class="table-responsive">   
                    <div id="gitReport">
                        Loading, Please Wait!.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    spinner = new jQuerySpinner({
        parentId: 'spinner'
    });
    spinner.show();

    function reload () {
        window.location.reload();
    }

    errorDiv = '<div class="row">'+
                '<img src="/error.png" class="margin-20">'
                +'</div>'+
                '<button class="btn btn-link" onclick="reload()"> Click here to reload</button>';

    $.ajax({
        url: '/git/show-users',
        type: "GET",
        success: function (response) {
            $("#gitReport").html(response);
            $("#searchbar").removeClass('hide');
            spinner.hide();
        },
        error: function(data) {
            $("#gitReport").html(errorDiv);
            spinner.hide();
        }
    });
    
    $('#searchUsersIcon').on( 'click', function (e) {
        $("#gitReport").html('Loading, Please Wait!');
        var searchValue = $('#searchUsers').val();
        if (searchValue) {
            spinner.show();
            $.ajax({
                url: '/git/search-users',
                type: "GET",
                data : {
                    search : searchValue
                },
                success: function (response) {
                    spinner.hide();
                    if (response) {
                        $("#gitReport").html(response);
                    } else {
                        var errorresponse = '<h3 class="red">*Invalid Username</h3>'
                        $("#gitReport").html(errorresponse+errorDiv);
                    }
                },
                error: function(data) {
                    $("#gitReport").html(errorDiv);
                    spinner.hide();
                }
            });    
        } 
    });

    $('#searchUsers').on( 'keyup', function (e) {
        var searchValue = $(this).val();
        if (!searchValue) {
            spinner.show();
            $.ajax({
                url: '/git/show-users',
                type: "GET",
                success: function (response) {
                    $("#gitReport").html(response);
                    $("#searchbar").removeClass('hide');
                    spinner.hide();
                },
                error: function(data) {
                    $("#gitReport").html(errorDiv);
                    spinner.hide();
                }
            });
        }
    });
</script>