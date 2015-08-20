<?php
    ini_set("auto_detect_line_endings", true);
    setlocale(LC_ALL, 0);

    //get separator options
    $import_csv_hierarchy_separator = '/';
    $import_csv_separator = isset($_POST['import_csv_separator']) && strlen($_POST['import_csv_separator']) == 1 ? $_POST['import_csv_separator'] : ';';

    $error_messages = array();

    if(isset($_FILES['import_csv']['tmp_name'])) {

        if(function_exists('wp_upload_dir')) {
            $upload_dir = wp_upload_dir();
            $upload_dir = $upload_dir['basedir'].'/csv_import';
        } else {
            $upload_dir = dirname(__FILE__).'/uploads';
        }

        if(!file_exists($upload_dir)) {
            $old_umask = umask(0);
            mkdir($upload_dir, 0755, true);
            umask($old_umask);
        }
        if(!file_exists($upload_dir)) {
            $error_messages[] = sprintf('Could not create upload directory %s.', $upload_dir );
        }

        //gets uploaded file extension for security check.
        $uploaded_file_ext = strtolower(pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION));

        //full path to uploaded file. slugifys the file name in case there are weird characters present.
        $uploaded_file_path = $upload_dir.'/'.sanitize_title(basename($_FILES['import_csv']['name'],'.'.$uploaded_file_ext)).'.'.$uploaded_file_ext;

        if($uploaded_file_ext != 'csv') {
            $error_messages[] = sprintf('The file extension %s is not allowed.', $uploaded_file_ext );

        } else {

            if(move_uploaded_file($_FILES['import_csv']['tmp_name'], $uploaded_file_path)) {
                $file_path = $uploaded_file_path;

            } else {
                $error_messages[] = sprintf( '%s returned false.', '<code>' . move_uploaded_file() . '</code>' );
            }
        }
    }

    if($file_path) {
        //now that we have the file, grab contents
        $handle = fopen($file_path, 'r' );
        $import_data = array();

        if ( $handle !== FALSE ) {
        	while ( ( $line = fgetcsv($handle, 0, $import_csv_separator) ) !== FALSE ) {
                $import_data[] = $line;
            }
            fclose( $handle );

        } else {
            $error_messages[] = 'Could not open file.';
        }

        if(intval($_POST['header_row']) == 1 && sizeof($import_data) > 0)
            $header_row = array_shift($import_data);

        $row_count = sizeof($import_data);
        if($row_count == 0)
            $error_messages[] = 'No data to import.';

    }

?>

<div class="woocommerce_product_shortlink_wrapper wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2>Woo Product Importer &raquo; Preview</h2>

    <?php if(sizeof($error_messages) > 0): ?>
        <ul class="import_error_messages">
            <?php foreach($error_messages as $message):?>
                <li><?php echo $message; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if($row_count > 0): ?>
        <form enctype="multipart/form-data" method="post" action="<?php echo get_admin_url().'tools.php?page=woocommerce-prodshort&action=result'; ?>">
            <input type="hidden" name="uploaded_file_path" value="<?php echo htmlspecialchars($file_path); ?>">
            <input type="hidden" name="import_csv_separator" value="<?php echo htmlspecialchars($import_csv_separator); ?>">
            <input type="hidden" name="header_row" value="<?php echo $_POST['header_row']; ?>">
            <input type="hidden" name="row_count" value="<?php echo $row_count; ?>">
            <input type="hidden" name="limit" value="5">

            <p>
                <button class="button-primary" type="submit">Import</button>
            </p>

            <table id="import_data_preview" class="wp-list-table widefat fixed pages" cellspacing="0">
                <thead>
                    <?php if(intval($_POST['header_row']) == 1): ?>
                        <tr class="header_row">
                            <th colspan="<?php echo sizeof($header_row); ?>">CSV Header Row</th>
                        </tr>
                        <tr class="header_row">
                            <?php foreach($header_row as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php foreach($import_data as $row_id => $row): ?>
                        <tr>
                            <?php foreach($row as $col): ?>
                                <td><?php echo htmlspecialchars($col); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php endif; ?>
</div>
