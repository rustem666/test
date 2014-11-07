<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test</title>
    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
    <script>
        $(function(){
            initFilter();

            $('#form-filter button').on('click', function(){
                initFilter();
            });
        });
        function initFilter(){
            $.ajax({
                url 	:   '/_get_data.php',
                data	:	$('#form-filter').serialize(),
                success :   function(data){
                    $('#result').html(data);
                }
            });
        }
    </script>
</head>
<body>
	<div>
		<div id='form-block'>
			<?php include_once '_form.php'; ?>
		</div>
		<div id="result"></div>
	</div>
</body>
</html>



