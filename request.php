<?php
session_start();
error_reporting(0);
include(__DIR__ . '/includes/config.php');
include(__DIR__ . '/includes/connect.php');

if (strlen($_SESSION['login']) == 0) {
    header('Location: index.php');
    exit;
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['id'];
        $producer = $_POST['producer'];
        $person_name = $_POST['person_name'];
        $telephone = $_POST['telephone'];
        $Region = $_POST['Region'];
        $agree = $_POST['agree'];
        $zone = $_POST['zone'];
        $email = $_POST['email'];
        $woreda = $_POST['woreda'];
        $R_date = date('Y/m/d');
        $noc = $_POST['noc'];
        $complaintdetials = $_POST['complaindetails'];

        // Create folders if not exist
        if (!is_dir(__DIR__ . '/complaintdocs')) {
            mkdir(__DIR__ . '/complaintdocs', 0755, true);
        }
        if (!is_dir(__DIR__ . '/cocdocs')) {
            mkdir(__DIR__ . '/cocdocs', 0755, true);
        }

        $compfile = $_FILES["compfile"]["name"];
        $cocfile = $_FILES["cocfile"]["name"];

        $compfileContent = file_get_contents($_FILES["compfile"]["tmp_name"]);
        $cocfileContent = file_get_contents($_FILES["cocfile"]["tmp_name"]);

        $compfileHash = md5($compfileContent);
        $cocfileHash = md5($cocfileContent);

        $compfileExtension = pathinfo($compfile, PATHINFO_EXTENSION);
        $cocfileExtension = pathinfo($cocfile, PATHINFO_EXTENSION);

        $newCompfileName = $compfileHash . '.' . $compfileExtension;
        $newCocfileName = $cocfileHash . '.' . $cocfileExtension;

        $newCompfilePath = __DIR__ . '/complaintdocs/' . $newCompfileName;
        $newCocfilePath = __DIR__ . '/cocdocs/' . $newCocfileName;

        if (move_uploaded_file($_FILES["compfile"]["tmp_name"], $newCompfilePath)) {
            echo "Compfile uploaded\n";
        } else {
            echo "Failed to upload Compfile\n";
        }

        if (move_uploaded_file($_FILES["cocfile"]["tmp_name"], $newCocfilePath)) {
            echo "Cocfile uploaded\n";
        } else {
            echo "Failed to upload Cocfile\n";
        }

        $query = mysqli_query($bd, "INSERT INTO tblcomplaints(userId, noc, complaintDetails, complaintFile, request_date, seed_producer, telephone, Person_Name, Region, email, cocdoc, mode, woreda, zones) 
        VALUES('$uid', '$noc', '$complaintdetials', '$newCompfileName', '$R_date', '$producer', '$telephone', '$person_name', '$Region', '$email', '$newCocfileName', '$agree', '$woreda', '$zone')");

        $l_id = mysqli_insert_id($bd);

        $sql = mysqli_query($bd, "SELECT complaintNumber FROM tblcomplaints ORDER BY complaintNumber DESC LIMIT 1");
        $cmpn = '';
        while ($row = mysqli_fetch_array($sql)) {
            $cmpn = $row['complaintNumber'];
        }

        for ($i = 0; $i < count($_POST['slno']); $i++) {
            $R_id = $l_id;
            $category = $_POST['category'][$i];
            $subcategory = $_POST['subcategory'][$i];
            $complaintype = $_POST['complaintype'][$i];
            $amount = $_POST['amount'][$i];

            if ($category && $subcategory && $complaintype && $amount && $R_id) {
                $sql = "INSERT INTO amount_detail(request, crop, variety, class, amount) 
                        VALUES('$R_id', '$category', '$subcategory', '$complaintype', '$amount')";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $last_id = $con->insert_id;

                $sqlevnt = mysqli_query($bd, "INSERT INTO inventory(product_id, qty, type, stock_from, form_id) 
                            VALUES('$subcategory', '0', '2', 'sales', '$last_id')");
            } else {
                echo '<div class="alert alert-danger" role="alert">Error Submitting Data</div>';
            }
        }

        echo '<script>alert("Your Request has been successfully submitted. Your RequestNo is ' . $cmpn . '")</script>';
        header('Location: dashboard.php');
        exit;
    }
}
?>