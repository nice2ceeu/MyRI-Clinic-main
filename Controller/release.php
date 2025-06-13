<?php
include("../config/database.php");

if (isset($_POST['release'])) {
    $id = $_POST['user_id']; // Patient ID
    $withMedicine = $_POST['treatment'];

    date_default_timezone_set('Asia/Manila');
    $checkout = date("h:i:s A");
    $dateConsumed = date("Y-m-d");

    if ($withMedicine == "yes") {
        $medicine = trim($_POST['medicine'] ?? '');
        $quantity = trim($_POST['medicine_qty'] ?? '');

        if ($medicine === "" || $quantity === "") {
            echo "<script>
                alert('Please fill all fields for medicinal treatment.');
                window.location.href = '../View/pages/Current-Patients.php';
            </script>";
            exit;
        }

        $medicineLower = strtolower($medicine);

        // Get current quantity from meds table
        $getCurrentQty = $conn->prepare("SELECT * FROM meds WHERE Medicine_Name = ?");
        $getCurrentQty->bind_param("s", $medicineLower);
        $getCurrentQty->execute();
        $result = $getCurrentQty->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currQty = (int)$row['Med_Quantity'];
            $medicine_id = $row['id']; // avoid overwriting $id

            if ($currQty < (int)$quantity) {
                echo "<script>
                    alert('Not enough stock.');
                    window.location.href = '../View/pages/Current-Patients.php';
                </script>";
                exit;
            }

            $newQty = $currQty - (int)$quantity;


            $stmt = $conn->prepare("UPDATE visitor SET withMedicine = ?, medicine = ?, Quantity = ?, checkout = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $withMedicine, $medicineLower, $quantity, $checkout, $id);
            $stmt->execute();


            $stmt1 = $conn->prepare("UPDATE meds SET Med_Quantity = ? WHERE Medicine_Name = ?");
            $stmt1->bind_param("is", $newQty, $medicineLower);
            $stmt1->execute();

            $stmtCheck = $conn->prepare("SELECT Med_Quantity FROM used_meds WHERE Medicine_name = ?");
            $stmtCheck->bind_param("s", $medicineLower);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $row = $resultCheck->fetch_assoc();
                $updatedQuantity = (int)$quantity + (int)$row['Med_Quantity'];


                $stmt3 = $conn->prepare("UPDATE used_meds SET Med_Quantity = ?, Date_Consumed = ? WHERE Medicine_name = ?");
                $stmt3->bind_param("iss", $updatedQuantity, $dateConsumed, $medicineLower);
            } else {

                $stmt3 = $conn->prepare("INSERT INTO used_meds (id, Medicine_name, Med_Quantity, Date_Consumed) VALUES (?, ?, ?, ?)");
                $stmt3->bind_param("isis", $id, $medicineLower, $quantity, $dateConsumed);
            }

            $stmt3->execute();

            echo "<script>
                alert('Patient record updated successfully.');
                window.location.href = '../View/pages/Current-Patients.php';
            </script>";
        } else {
            echo "<script>
                alert('Medicine not found in inventory.');
                window.location.href = '../View/pages/Current-Patients.php';
            </script>";
        }
    } else if ($withMedicine == "no") {
        $physicalTreatment = trim($_POST['physical-treatment'] ?? '');

        if ($physicalTreatment === "") {
            echo "<script>
                alert('Please fill all fields for physical treatment.');
                window.location.href = '../View/pages/Clinic-Patient.php';
            </script>";
            exit;
        }

        $stmt = $conn->prepare("UPDATE visitor SET physical_treatment = ?, checkout = ? WHERE id = ?");
        $stmt->bind_param("ssi", $physicalTreatment, $checkout, $id);
        $stmt->execute();

        echo "<script>
            alert('Patient record updated successfully.');
            window.location.href = '../View/pages/Current-Patients.php';
        </script>";
    }
}
