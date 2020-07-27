<?php
echo "Created date is " . date("Y-m-d h:i:sa");
delete_files('/var/www/runtime/debug/');
delete_files('/var/www/runtime/logs/');
delete_files('/var/www/runtime/cache/');

delete_files('/var/www/backend/runtime/debug/');
delete_files('/var/www/backend/runtime/logs/');
delete_files('/var/www/backend/runtime/cache/');

function delete_files($target) {
  //  echo '<pre>';    print_r($target);    exit;
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
        foreach ($files as $file) {
            if (is_dir($file)) {
                $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
                foreach ($files as $file) {
                    delete_files($file);
                }
                rmdir($file);
            } elseif (is_file($target)) {
                unlink($target);
            }
            delete_files($file);
        }
    } elseif (is_file($target)) {
        unlink($target);
    }
}
