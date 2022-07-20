<?php echo 'Redirecting to Flutter Wave....'; ?>
<html>
<head>
    <script type="text/javascript">       
        function submit() {          
           document.forms.flutterwave.submit();           
        }
    </script>
</head>
<body onload="submit()">
    
    <form method="POST" name="flutterwave" action="https://checkout.flutterwave.com/v3/hosted/pay">  
        <input type="hidden" name="public_key" value="<?php echo $public_key; ?>" />
        <input type="hidden" name="customer[email]" value="<?php echo $email; ?>" />
        <input type="hidden" name="customer[name]" value="<?php echo $name; ?>" />
        <input type="hidden" name="tx_ref" value="<?php echo $tx_ref; ?>" />
        <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
        <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
        <input type="hidden" name="meta[token]" value="<?php echo $token; ?>" />
        <input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>" />
      </form>
</body>
</html>
