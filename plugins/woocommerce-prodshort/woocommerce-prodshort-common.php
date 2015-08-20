<style type="text/css">
    .woocommerce_product_shortlink_wrapper form { padding: 20px 0; }

    .woocommerce_product_shortlink_wrapper .import_error_messages {
        margin: 6px 0;
        padding: 0;
    }

    .woocommerce_product_shortlink_wrapper .import_error_messages li {
        margin: 2px 0;
        padding: 4px;
        background-color: #f9dede;
        border: 1px solid #ff8e8e;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .woocommerce_product_shortlink_wrapper #import_status {
        padding: 8px 8px 8px 82px;
        min-height: 66px;
        position: relative;
        margin: 6px 0;
        background-color: #fff5d1;
        border: 1px solid #ffc658;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .woocommerce_product_shortlink_wrapper #import_status.complete {
        background-color: #ecfdbe;
        border: 1px solid #a1dd00;
    }

    .woocommerce_product_shortlink_wrapper #import_status img {
        position: absolute;
        top: 8px;
        left: 8px;
    }

    .woocommerce_product_shortlink_wrapper #import_status strong {
        font-size: 18px;
        line-height: 1.2em;
        padding: 6px 0;
        display: block;
    }

    .woocommerce_product_shortlink_wrapper #import_status #import_in_progress { display: block; }
    .woocommerce_product_shortlink_wrapper #import_status.complete #import_in_progress { display: none; }

    .woocommerce_product_shortlink_wrapper #import_status #import_complete { display: none; }
    .woocommerce_product_shortlink_wrapper #import_status.complete #import_complete { display: block; }

    .woocommerce_product_shortlink_wrapper #import_status td,
    .woocommerce_product_shortlink_wrapper #import_status th {
        text-align: left;
        font-size: 13px;
        line-height: 1em;
        padding: 4px 10px 4px 0;
    }

    .woocommerce_product_shortlink_wrapper table th { vertical-align: top; }

    .woocommerce_product_shortlink_wrapper table.super_wide th,
    .woocommerce_product_shortlink_wrapper table.super_wide td {
        width: 120px;
        min-width: 120px;
    }

    .woocommerce_product_shortlink_wrapper table.super_wide th.narrow,
    .woocommerce_product_shortlink_wrapper table.super_wide td.narrow
    .woocommerce_product_shortlink_wrapper table th.narrow,
    .woocommerce_product_shortlink_wrapper table td.narrow {
        width: 65px;
    }
    .woocommerce_product_shortlink_wrapper table input { margin: 1px 0; }

    .woocommerce_product_shortlink_wrapper table tr.header_row th {
        background-color: #DCEEF8;
        background-image: none;
        vertical-align: middle;
    }

    .woocommerce_product_shortlink_wrapper .map_to_settings {
        margin: 2px 0;
        padding: 2px;
        overflow: hidden;
    }
    .woocommerce_product_shortlink_wrapper .map_to_settings select { width: 98%; }

    .woocommerce_product_shortlink_wrapper .field_settings {
        
        margin: 2px 0;
        padding: 4px;
        background-color: #e0e0e0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .woocommerce_product_shortlink_wrapper .field_settings h4 {
        margin: 0;
        font-size: 0.9em;
        line-height: 1.2em;
    }
    .woocommerce_product_shortlink_wrapper .field_settings p {
        margin: 4px 0;
        overflow: hidden;
        font-size: .9em;
        line-height: 1.3em;
    }
    .woocommerce_product_shortlink_wrapper .field_settings select { width: 98%; }
    .woocommerce_product_shortlink_wrapper .field_settings input[type="text"] { width: 98%; }

    .woocommerce_product_shortlink_wrapper #inserted_rows tr.error td { background-color: #FFF6D3; }
    .woocommerce_product_shortlink_wrapper #inserted_rows tr.fail td { background-color: #FFA8A8; }

    .woocommerce_product_shortlink_wrapper #inserted_rows .icon {
        display: block;
        width: 16px;
        height: 16px;
        background-position: 0 0;
        background-repeat: no-repeat;
    }
    .woocommerce_product_shortlink_wrapper #inserted_rows tr.success .icon { background-image: url('<?php echo plugin_dir_url(__FILE__); ?>img/accept.png'); }
    .woocommerce_product_shortlink_wrapper #inserted_rows tr.error .icon { background-image: url('<?php echo plugin_dir_url(__FILE__); ?>img/error.png'); }
    .woocommerce_product_shortlink_wrapper #inserted_rows tr.fail .icon { background-image: url('<?php echo plugin_dir_url(__FILE__); ?>img/exclamation.png'); }

    .woocommerce_product_shortlink_wrapper #debug {
        display: none;
        font-family: monospace;
        font-size: 14px;
        line-height: 16px;
        color: #333;
        background-color: #f5f5f5;
        border: 1px solid #efefef;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        padding: 0 10px;
    }

    .woocommerce_product_shortlink_wrapper #credits {
        margin: 20px 0 6px;
    }

    .woocommerce_product_shortlink_wrapper #credits p {
        margin: 2px 0;
    }

    .woocommerce_product_shortlink_wrapper #donate_form {
        float: left;
        margin: 0 6px;
        padding: 0;
    }

    .woocommerce_product_shortlink_wrapper #donate_form form {
        margin: 0;
        padding: 0;
    }
</style>
