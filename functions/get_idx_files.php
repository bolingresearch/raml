<?php
/**
 * Downloads and extracts data files and image archives from
 * the IDX server.
 *
 * @param FTP $conn
 * @param string $local_temp_dir
 * @param string $local_images_dir
 * @param string[] $files Filenames to download and extract.
 */
function get_idx_files($conn, $temp_dir, $images_dir, $files = array() ) {


    // include Tar class
    require_once("Archive/Tar.php");


    echo "<div style='height:150px; width:400px; overflow:auto; border: solid 1px #222;'>";


    foreach ($files as $remote_file) {
        echo "<p>";

        $local_file = $temp_dir.$remote_file;

        ftp_get($conn, $local_file, $remote_file, FTP_BINARY) or die("ERROR: Cannot download $remote_file");
        echo "$remote_file successfully downloaded.<br />";

        // if text file
        if (preg_match("/txt.gz/", $remote_file) == 1) {
            if (file_exists(substr($local_file, 0, -3))) {
                unlink(substr($local_file, 0, -3));
            }
            `gunzip $local_file`;
            // check if file was successfully unzipped
            if (file_exists(substr($local_file, 0, -3))) {
                echo "$remote_file unzipped.";
            }
        }

        // if images archive
        if (preg_match("/.tar/", $remote_file) == 1) {

        // use tar file
            $tar = new Archive_Tar($local_file);
            if (is_writable($images_dir)) {
                if ($tar->extract($images_dir)) {
                    echo "Images extracted.<br />";
                }
                if(file_exists($local_file)) {
                    if (unlink($local_file)) {
                        echo 'Archive file deleted.<br />';
                    } else {
                        echo 'Check your folder permissions. The archive file could not be deleted.<br />';
                    }
                }
            } else {
                echo "Images directory is not writable.<br />";
            }
        }
        echo "</p>";
    }
    echo "</div>";
}
?>