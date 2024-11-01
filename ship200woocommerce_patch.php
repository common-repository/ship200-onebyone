<!-- START OF SHIP200 ONEBYONE INTEGRATION CODE -->
<?php
global $wpdb;
$weburl = get_site_url()."/?ship200onebyone=ship200-onebyone|AND|id=";
$one_settings = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ". $wpdb->prefix . "ship200onebyone WHERE shipid = %d", 1) );
?>
<script>
    var ship200Address = [

        '<?php echo esc_js($order->shipping_first_name) ?>  <?php echo esc_js($order->shipping_last_name) ?>', //0 Name
        '<?php echo esc_js($order->shipping_company) ?>',    //1 Company Name

        '<?php echo esc_js($order->shipping_address_1) ?>',        //2 Address Line 1

        '<?php echo esc_js($order->shipping_address_2) ?>',        //3 Address Line 2

        '<?php echo esc_js($order->shipping_city) ?>',        //4 City

        '<?php echo esc_js($order->shipping_state) ?>',        //5 State

        '<?php echo esc_js($order->shipping_postcode) ?>',        //6 Zip

        '<?php echo esc_js($order->shipping_country) ?>',        //7 Country

        '<?php echo esc_js($order->billing_phone) ?>',        //8 Phone

        'order number: <?php echo esc_js($order->id) ?>',        //9 Refference (will be printed on the label)

        '<?php echo esc_js($order->order_total) ?>',        //10 Declared Value

        '',        //11 Weight

        '',        //12 Weight Units (lb or oz): valid values are 'lb' or 'oz'

        '',        //13 Dimensions Length

        '',        //14 Dimensions Width

        '',        //15 Dimensions Height

        '<?php echo esc_js($one_settings->shippingmethod); ?>',        //16 Default Carrier Service, example 'USPS-01', 'Fedex-01', 'UPS-03-S', etc. !Full list of codes: http://secure.ship200.com/html/images/help/service_codes

        '<?php if($one_settings->tracking == "yes"){echo esc_js($order->id);} ?>',        //17 Key (usually order number) for sending tracking number back, if set the url below is required, example '349001'

        '<?php if($one_settings->tracking == "yes"){echo esc_js($weburl."".$one_settings->ship200key);}?>'  //18 URL for sending tracking back, example 'http://www.yourdomain.com/admin-folder/ship200_postback.php?id=yourKey123'

    ];

    var ship200URL = '';

    for (var i in ship200Address) {

        if(i != 18)

            ship200Address[i]=ship200Address[i].replace(/[^a-z0-9., '-]/gi,'');

        ship200URL += ship200Address[i]+'}{';

    }

    var ship200Width = "978";
    var ship200Height = "832";

    function open_ship200(){ ship200window = window.open('https://secure.ship200.com/shipping.php?action=new_label&shipto='+ship200URL,'ship200','width='+ship200Width+',height='+ship200Height+',scrollbars=yes'); ship200window.focus();}

    function open_ship200_return(){ ship200window = window.open('https://secure.ship200.com/shipping.php?action=new_label&print_return=1&shipto='+ship200URL,'ship200','width='+ship200Width+',height='+ship200Height+',scrollbars=yes'); ship200window.focus();}

</script>
<button value="Make Return PDF Label" onclick="open_ship200_return();" class="btn grey return">
    <span>Make Return PDF Label</span>
</button>

<button value="Create Shipping Label" onclick="open_ship200();" class="btn grey ship">
    <span>Create Shipping Label</span>
</button>

<!-- END OF SHIP200 ONEBYONE INTEGRATION CODE -->

<div class="panel-wrap woocommerce">