<div class="woocommerce_product_shortlink_wrapper wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2>Woo Product Importer &raquo; Upload</h2>

    <form enctype="multipart/form-data" method="post" action="<?php echo get_admin_url().'tools.php?page=woocommerce-prodshort&action=preview'; ?>">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="import_csv">File to Import</label></th>
                    <td><input type="file" name="import_csv" id="import_csv"></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="checkbox" name="header_row" id="header_row" value="1">
                        <label for="header_row">First Row is Header Row</label>
                    </td>
                </tr>
                <tr>
                    <th>CSV field separator</th>
                    <td>
                        <input type="text" name="import_csv_separator" id="import_csv_separator" class="code" value=";" maxlength="1">
                        <p class="description">Enter the character used to separate each field in your CSV. The default is the semicolon (;) character. Some formats use a comma (,) instead.</p>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <button class="button-primary" type="submit">Upload and Preview</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
