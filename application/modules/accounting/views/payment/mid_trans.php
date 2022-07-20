<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $mid_client_key; ?>"></script>
        <script src="<?php echo JS_URL; ?>jquery-1.11.2.min.js"></script>
    </head>
    <body onload="submit()">
        <script type="text/javascript">
            function submit() {
                snap.pay('<?php echo $snap_token; ?>', {
                    onSuccess: function (result) {
                        var post = JSON.stringify(result);
                        $.ajax({
                            url: "<?php echo base_url('accounting/payment/midtrans_success/'.$invoice_id); ?>",
                            type: 'POST',
                            data: {'data': post},
                            dataType: "json",
                            success: function (res) {
                                console.log(res);
                                window.location.href = res.url;
                            }
                        });
                    },
                    onPending: function (result) {
                        console.log(result);
                    },
                    onError: function (result) {
                        console.log(result);
                    }
                });
            }
        </script>
    </body>
</html>
