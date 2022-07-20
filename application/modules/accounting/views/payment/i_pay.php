<?php echo 'Redirecting to iPay....'; ?>
<html>
<head>
    <script type="text/javascript">       
        function submit() {          
           document.forms.i_pay.submit();           
        }
    </script>
</head>
<body onload="submit()">
    <form action="https://payments.ipayafrica.com/v3/ke" method="post" name="i_pay">       
        <?php
        foreach ($fields as $key => $value) {
            echo ' <input name="' . $key . '" type="hidden" value="' . $value . '"></br>';
        }
        ?>
        <input name="hsh" type="hidden" value="<?php echo $generated_hash ?>" />
    </form>
</body>
</html>
