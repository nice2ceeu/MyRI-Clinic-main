<?php
include('../View/components/body.php');

?>
<main class="uppercase mt-22 px-8.5">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr class="">

                <th>ID</th>
                <th>FULL NAME</th>
                <th>Grade and Section</th>
                <th>complaint</th>
                <th>Time in</th>
                <th>Time Out</th>
                <th>Date</th>
                <th>treatment</th>
                <th>Qty.</th>

            </tr>
        </thead>
        <tbody
            class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include('../config/database.php');
            include('../View/components/body.php');
            if (isset($_POST['view-history'])) {
                $firstname = $_POST['fname'];
                $lastname = $_POST['lname'];

                try {
                    $stmt = $conn->prepare("SELECT * FROM visitor WHERE firstname = ? and lastname =?");
                    $stmt->bind_param("ss", $firstname, $lastname);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                            $id = htmlspecialchars($row['id']);
                            echo "<tr class=''>";
                            echo "<td>" . $id . "</td>";
                            echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                            echo "<td>" . $treatment . "</td>";
                            echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<script>alert('No User Found');
                            window.location.href = '../view/pages/studentlist.php';
                        </script>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            ?>
    </table>