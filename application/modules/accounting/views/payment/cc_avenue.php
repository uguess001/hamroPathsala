<?php echo 'Redirecting to CCAvenue....'; ?>
<html>
<head>
    <script type="text/javascript">       
        function submit() {          
           document.forms.ccavenue.submit();           
        }
    </script>
</head>
<body onload="submit()">
    <form action="<?php echo $api_link; ?>" method="post" name="ccavenue">
        <?php
        echo '<input type="hidden" name="encRequest" value="'.$encrypt_request.'">';
        echo '<input type=hidden name="access_code" value="'.$access_code.'">';
        ?>
    </form>
</body>
</html>
