<?php
    ini_set("auto_detect_line_endings", true);

    $post_data = array(
        'uploaded_file_path' => $_POST['uploaded_file_path'],
        'header_row' => $_POST['header_row'],
        'limit' => $_POST['limit'],
        'offset' => $_POST['offset'],
        'import_csv_separator' => maybe_unserialize(stripslashes($_POST['import_csv_separator'])),
    );

    if(isset($post_data['uploaded_file_path'])) {
        // Set default locale
        setlocale(LC_ALL, 0);

        $error_messages = array();

        //now that we have the file, grab contents
        $temp_file_path = $post_data['uploaded_file_path'];
        $handle = fopen( $temp_file_path, 'r' );
        $import_data = array();

        if ( $handle !== FALSE ) {
            while ( ( $line = fgetcsv($handle, 0, $post_data['import_csv_separator']) ) !== FALSE ) {
                $import_data[] = $line;
            }
            fclose( $handle );
        } else {
            $error_messages[] = 'Could not open CSV file.';
        }

        if(sizeof($import_data) == 0) {
            $error_messages[] = 'No data found in CSV file.';
        }

        //discard header row from data set, if we have one
        if(intval($post_data['header_row']) == 1) array_shift($import_data);

        //total size of data to import (not just what we're doing on this pass)
        $row_count = sizeof($import_data);

        //slice down our data based on limit and offset params
        $limit = intval($post_data['limit']);
        $offset = intval($post_data['offset']);
        if($limit > 0 || $offset > 0) {
            $import_data = array_slice($import_data, $offset , ($limit > 0 ? $limit : null), true);
        }

        //a few stats about the current operation to send back to the browser.
        $rows_remaining = ($row_count - ($offset + $limit)) > 0 ? ($row_count - ($offset + $limit)) : 0;
        $insert_count = ($row_count - $rows_remaining);
        $insert_percent = number_format(($insert_count / $row_count) * 100, 1);

        //array that will be sent back to the browser with info about what we inserted.
        $inserted_rows = array();

        //this is where the fun begins
        foreach($import_data as $row_id => $row) {
            //track whether or not the post was actually inserted.
            $new_post_insert_success = false;
            //output messages
            $new_post_messages = array();

            //array of imported post_meta
            $new_post_meta = array();

            $new_post_meta['_sku'] = $row[0];
            $new_post_meta['short_link'] = $row[1];

            //try to find a product with a matching SKU
            $existing_product = null;
            if(array_key_exists('_sku', $new_post_meta) && !empty($new_post_meta['_sku']) > 0) {
                $existing_post_query = array(
                    'numberposts' => 1,
                    'meta_key' => '_sku',
                    'meta_query' => array(
                        array(
                            'key'=>'_sku',
                            'value'=> $new_post_meta['_sku'],
                            'compare' => '='
                        )
                    ),
                    'post_type' => 'product');
                $existing_posts = get_posts($existing_post_query);
                if(is_array($existing_posts) && sizeof($existing_posts) > 0) {
                    $existing_product = array_shift($existing_posts);
                }
            }

            if($existing_product !== null) {

                //search product id
                if($existing_product !== null) {
                    $new_post_messages[] = sprintf( 'Updating product with ID %s.', $existing_product->ID );

                    $new_post['ID'] = $existing_product->ID;
                    $new_post_id = wp_update_post($new_post);
                }

                if(is_wp_error($new_post_id) || $new_post_id == 0) {
                    $new_post_errors[] = sprintf( 'Couldn\'t update product with ID %s.', $new_post['ID'] );
                } else {
                    //insert successful!
                    $new_post_insert_success = true;

                    //set post_meta on inserted post
                    foreach($new_post_meta as $meta_key => $meta_value) {
                        add_post_meta($new_post_id, $meta_key, $meta_value, true) or
                            update_post_meta($new_post_id, $meta_key, $meta_value);
                    }
                }

            } else {
                $new_post_errors[] = 'Skipped import of product, SKU does not matchs';
            }

            //this is returned back to the results page.
            //any fields that should show up in results should be added to this array.
            $inserted_rows[] = array(
                'row_id' => $row_id,
                'post_id' => $new_post_id ? $new_post_id : '',
                'sku' => $new_post_meta['_sku'] ? $new_post_meta['_sku'] : '',
                'has_errors' => (sizeof($new_post_errors) > 0),
                'errors' => $new_post_errors,
                'has_messages' => (sizeof($new_post_messages) > 0),
                'messages' => $new_post_messages,
                'success' => $new_post_insert_success
            );
        }
    }

    echo json_encode(array(
        'remaining_count' => $rows_remaining,
        'row_count' => $row_count,
        'insert_count' => $insert_count,
        'insert_percent' => $insert_percent,
        'inserted_rows' => $inserted_rows,
        'error_messages' => $error_messages,
        'limit' => $limit,
        'new_offset' => ($limit + $offset)
    ));
?>
