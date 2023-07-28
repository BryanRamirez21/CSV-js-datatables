<?php 
    /*
        here we have a php code wich will recive the form data, if theres a file and a post data, if there is, all the csv data will be split in
        json format, that way we will put that array in a json file so we can retrive it in a jquery file; if we go to the url (not reload, that
        doesnt work) the json file will wirte nothing so the datable doesnt show
    */
    $json_data = 'json-data.json';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
        $file = $_FILES['csv']['tmp_name'];
        if(is_uploaded_file($file)){
            $data = [];
            if(file_exists($json_data))
                unlink($json_data);

            if(($read_file = fopen($file, 'r')) !== false){
                while(($row = fgetcsv($read_file, 0, ',')) !== false){
                    $data[] = $row; 
                }
                fclose($read_file);
                
                if(!empty($data)){
                    file_put_contents($json_data, json_encode($data));
                }
            }
        }
    }else{
        file_put_contents($json_data, '');
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSV - datatables</title>
        <!-- Ajax -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
        <!-- Validations -->
        <script src="readCSV.js"></script>
    </head>
    <body>
        <form action="" method="post" enctype="multipart/form-data" style="margin: 30px; border-style:solid">
            <label><h1>Upload CSV</h1></label>
            <input type="file" name="csv" accept=".csv" required>
            <input type="submit" value="upload" />
        </form>

        <table id="myTable" class="display" >
            <thead>
                <tr id="tableHead"></tr>
            </thead>
            <tbody></tbody>
        </table>

    </body>
</html>

