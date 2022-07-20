<html>
    <head>
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body onload="submit()">
        <script type="text/javascript">
            var stripe = Stripe("<?php echo $stripe_publishable; ?>");
            function submit() {
                stripe.redirectToCheckout({sessionId: "<?php echo $session_id; ?>"});
            }
        </script>
    </body>
</html>
