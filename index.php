<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bootstrap Template </title>
    <!-- link css files Start -->
    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- fontawesome Css -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <!-- link css file end -->
</head>

<body>
    <br/>
    <div class="container">
        <h3 align="center"> Live Data Search with Pagination in PHP Mysql using Ajax </h3>
        <br/>
        <div class="card">
            <div class="card-header">Dynamic Data</div>
            <div class="card-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Search......." />
                </div>
                <div id="dynamic_content" class="table-responcive"></div>
            </div>
        </div>
    </div>
    <!-- include js files start -->
    <script src="assets/js/jquery-3.5.1.js"></script>
    <!-- <script src="assets/js/custom-js.js"></script> -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <!-- include js files end -->
    <script>
        $(document).ready(function(){
            
            load_data(1);

            function load_data(page, query=''){
                $.ajax({
                    url: 'fetch.php',
                    method: 'POST',
                    data:{page:page, query:query},
                    success:function(data){
                        $('#dynamic_content').html(data);
                    } 
                });
            }
            
            $('#search_box').keyup(function(){
                var query = $('#search_box').val();
                load_data(1, query);
            });

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page');
                var query = $('#search_box').val();
                load_data(page, query);
            });

        });
    </script>
</body>

</html>