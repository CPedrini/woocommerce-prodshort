<?php
    $post_data = array(
        'uploaded_file_path' => $_POST['uploaded_file_path'],
        'header_row' => $_POST['header_row'],
        'limit' => intval($_POST['limit']),
        'import_csv_separator' => $_POST['import_csv_separator'],
    );
?>
<script type="text/javascript">
    jQuery(document).ready(function($){

        $("#show_debug").click(function(){
            $("#debug").show();
            $(this).hide();
        });

        doAjaxImport(<?php echo $post_data['limit']; ?>, 0);

        function doAjaxImport(limit, offset) {
            var data = {
                "action": "woocommerce-prodshort-ajax",
                "uploaded_file_path": <?php echo json_encode($post_data['uploaded_file_path']); ?>,
                "header_row": <?php echo json_encode($post_data['header_row']); ?>,
                "limit": limit,
                "offset": offset,
                "import_csv_separator": '<?php echo (serialize($post_data['import_csv_separator'])); ?>',
            };

            //ajaxurl is defined by WordPress
            $.post(ajaxurl, data, ajaxImportCallback);
        }

        function ajaxImportCallback(response_text) {

            $("#debug").append($(document.createElement("p")).text(response_text));

            var response = jQuery.parseJSON(response_text);

            $("#insert_count").text(response.insert_count + " (" + response.insert_percent +"%)");
            $("#remaining_count").text(response.remaining_count);
            $("#row_count").text(response.row_count);

            //show inserted rows
            for(var row_num in response.inserted_rows) {
                var tr = $(document.createElement("tr"));

                if(response.inserted_rows[row_num]['success'] == true) {
                    if(response.inserted_rows[row_num]['has_errors'] == true) {
                        tr.addClass("error");
                    } else {
                        tr.addClass("success");
                    }
                } else {
                    tr.addClass("fail");
                }

                var post_link = $(document.createElement("a"));
                post_link.attr("target", "_blank");
                post_link.attr("href", "<?php echo get_admin_url(); ?>post.php?post=" + response.inserted_rows[row_num]['post_id'] + "&action=edit");
                post_link.text(response.inserted_rows[row_num]['post_id']);

                tr.append($(document.createElement("td")).append($(document.createElement("span")).addClass("icon")));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['row_id']));
                tr.append($(document.createElement("td")).append(post_link));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['sku']));

                var result_messages = "";
                if(response.inserted_rows[row_num]['has_messages'] == true) {
                    result_messages += response.inserted_rows[row_num]['messages'].join("\n") + "\n";
                }
                if(response.inserted_rows[row_num]['has_errors'] == true) {
                    result_messages += response.inserted_rows[row_num]['errors'].join("\n") + "\n";
                } else {
                    result_messages += "No errors.";
                }
                tr.append($(document.createElement("td")).text(result_messages));

                tr.appendTo("#inserted_rows tbody");
            }

            //show error messages
            for(var message in response.error_messages) {
                $(document.createElement("li")).text(response.error_messages[message]).appendTo(".import_error_messages");
            }

            //move on to the next set!
            if(parseInt(response.remaining_count) > 0) {
                doAjaxImport(response.limit, response.new_offset);
            } else {
                $("#import_status").addClass("complete");
            }
        }
    });
</script>

<div class="woocommerce_product_shortlink_wrapper wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2>Woo Product Importer &raquo; Results</h2>

    <ul class="import_error_messages">
    </ul>

    <div id="import_status">
        <div id="import_in_progress">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>img/ajax-loader.gif"
                alt="Importing. Please do not close this window or click your browser's stop button."
                title="Importing. Please do not close this window or click your browser's stop button.">

            <strong>Importing. Please do not close this window or click your browser's stop button.</strong>
        </div>
        <div id="import_complete">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>img/complete.png"
                alt="Import complete!"
                title="Import complete!">
            <strong>Import Complete! Results below.</strong>
        </div>

        <table>
            <tbody>
                <tr>
                    <th>Processed</th>
                    <td id="insert_count">0</td>
                </tr>
                <tr>
                    <th>Remaining</th>
                    <td id="remaining_count"><?php echo $post_data['row_count']; ?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td id="row_count"><?php echo $post_data['row_count']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <table id="inserted_rows" class="wp-list-table widefat fixed pages" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 30px;"></th>
                <th style="width: 80px;">CSV Row</th>
                <th style="width: 80px;">New Post ID</th>
                <th>SKU</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody><!-- rows inserted via AJAX --></tbody>
    </table>

    <p><a id="show_debug" href="#" class="button">Show Raw AJAX Responses</a></p>
    <div id="debug"><!-- server responses get logged here --></div>
</div>
