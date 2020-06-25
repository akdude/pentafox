<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Git Users Dashboard</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/git.css">
    </head>
    <body>
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
    </body>
</html>
<script type="text/javascript">
    $.ajax({
        url: '/git/show-users',
        type: "GET",
        success: function (response) {
            $("#gitReport").html(response);
            $("#searchbar").removeClass('hide');
        },
        error: function(data) {
            $("#gitReport").html('Please try again');
        }
    });
    
    $('#searchUsersIcon').on( 'click', function (e) {
        $("#gitReport").html('Loading, Please Wait!');
        var searchValue = $('#searchUsers').val();
        if (searchValue) {
            $.ajax({
                url: '/git/search-users',
                type: "GET",
                data : {
                    search : searchValue
                },
                success: function (response) {
                    $("#gitReport").html(response);
                }
            });    
        } 
    });

    $('#searchUsers').on( 'keyup', function (e) {
        var searchValue = $(this).val();
        if (!searchValue) {
            $.ajax({
                url: '/git/show-users',
                type: "GET",
                success: function (response) {
                    $("#gitReport").html(response);
                    $("#searchbar").removeClass('hide');
                },
                error: function(data) {
                    $("#gitReport").html('Please try again');
                }
            });
        }
    });
</script>