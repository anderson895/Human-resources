<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

$employee_id = $_POST['id'];
$where = [
    "employee_id = '".$employee_id."'"
];
$rows = $db->getAllRowsFromTableWhere("employee_files", $where);

foreach ($rows as $row) {
    $file = $row['file'];
    $file_type = $row['file_type'];
    $description = $row['description'];
    $employee_file_id = $row['id'];
    $file_url = 'http://localhost/hris/admin/uploads/' . $file; // URL where files are accessible

    // Check if the file exists using cURL
    $ch = curl_init($file_url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $file_exists = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;
    curl_close($ch);

    // Get file size and type
    $fileSize = $file_exists ? filesize('../uploads/' . $file) : 'N/A';
    $fileType = $file_exists ? mime_content_type('../uploads/' . $file) : 'N/A';
    $fileSizeFormatted = $fileSize !== 'N/A' ? round($fileSize / 1024, 2) . ' KB' : 'N/A';

    $data='
    data-id="'.$employee_file_id.'"
    ';


    if ($file_exists) {
        echo '<tr>
                <td>'.$file_type.'</td>
                <td>
                    <a href="'.$file_url.'" title="Click to download" download="'.$file.'">'.$file.'</a>
                    <br><small>Size: '.$fileSizeFormatted.' | Type: '.$fileType.'</small>
                </td>
                <td>'.$description.'</td>

                <td class="text-center">
                    <button type="button" '.$data.' class="btn btnDeleteFile btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </td>
            </tr>';
    } else {
        echo '<tr>
                <td>'.$description.'</td>
                <td>File not available</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </td>
            </tr>';
    }
}
?>
