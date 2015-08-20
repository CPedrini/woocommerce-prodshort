# woocommerce-prodshort
Massive csv importer for WooCommerce WP plugin

## Instructions:
1. Drop files inside WP root directory and replace all.
2. Activate plugin called: "WooCommerce Product Shortlinks Importer".
3. Go to menu: Tools / Woo ProdShort Importer.
  * Select file to import, use configuration according it and upload.
  * Review columns and import.
  * Wait until process finish. It does ajax request until finish.

## Notes:

**Plugin:**  
Folder: wp_modified/wp-content/plugins/woocommerce-prodshort/  
Name: WooCommerce Product Shortlinks Importer  
Menu: Tools / Woo ProdShort Importer.  
CSV sample: attached.  
What it does: Add custom field "short_link" with provided value.  

**Theme:**  
Folder: wp_modified/wp-content/themes/glammy/woocommerce/single-product/add-to-cart/  
File: simple.php  
Changes from original: Removed button and quantities, added direct link referencing product custom field.