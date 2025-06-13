<?php
include("body.php")
?>
<style>
    /* Background overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
    }

    /* Popup with-medicine */
    .popup {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 500px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .close-btn {
        cursor: pointer;
        margin-top: 10px;
        color: red;
    }
</style>
<main

    class="uppercase mt-22 px-8.5 ">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>ID</th>
                <th>Name of student</th>
                <th>grade and section</th>
                <th>complaint</th>
                <th>TIME IN</th>
                <th>DATE</th>
                <th>action</th>
            </tr>

        </thead>


        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include("../../config/database.php");




            try {
                $query = "SELECT * FROM visitor where checkout = '' order by checkin desc";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);
                        echo "<tr class=''>";
                        echo "<td >" . $id . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['_date']) . "</td>";

                        echo  "<td>  
                                    <button onclick='showPopup($id)' class='bg-primary text-white rounded-lg uppercase py-2.5 px-5 flex gap-5 items-center justify-evenly cursor-pointer'>
                                        <p>Patient out</p>
                                        <img class='w-4 h-4' src='../assets/icons/out-icon.svg' alt='check icon' />
                                    </button>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr '>";
                    echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "No Current Patient." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
            <?php
            // Fetch medicine options once
            $medOptions = "";
            $query = "SELECT Medicine_Name FROM meds where Med_Quantity > 0";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $med = htmlspecialchars($row['Medicine_Name']);
                    $medOptions .= "<option value='$med'>$med</option>";
                }
            }

            echo "
              <!-- Popup Overlay -->
<div class='overlay' id='popupOverlay'>
    <div class='popup'>
        <form action='../../Controller/release.php' method='POST'>
            With medicine? <br>

            <input type='radio' id='with-medicine' name='treatment' value='yes' onclick='toggleMedSection()' required>
            <label for='with-medicine'>Medicinal Treatment</label>

            <input type='radio' id='no-medicine' name='treatment' value='no' onclick='toggleMedSection()' required>
            <label for='no-medicine'>No Medicine Used</label>

            <div id='with-medicine-treatment' style='display: none;'>
                <label>Medicine Used</label>
                <select name='medicine' id='medicine' class='border-1 p-3.5 w-full'>
    <option disabled selected value='' class='opacity-40'>Select Medicine</option>
    $medOptions
</select>



                <label>Medicine Quantity</label>
                <input type='number' name='medicine_qty'>
            </div>

            <div id='without-medicine-treatment' style='display: none;'>
                <label for='physical-treatment'>PHYSICAL TREATMENT</label>
                <input type='text' id='physical-treatment' name='physical-treatment'>
            </div>

            <input type='hidden' id='id' name='user_id'>

            <div class='close-btn' onclick='hidePopup()'>Cancel</div>
            <button type='submit' name='release'><span style='color:green;'>RELEASE</span></button>
        </form>
    </div>
</div>

" .


                "<script>
                    function toggleMedSection() {
                        const withMedSection = document.getElementById('with-medicine-treatment');
                        const withoutMedSection = document.getElementById('without-medicine-treatment');
                        const isWithMed = document.getElementById('with-medicine').checked;
                        const isWithoutMed = document.getElementById('no-medicine').checked;

                        withMedSection.style.display = isWithMed ? 'block' : 'none';
                        withoutMedSection.style.display = isWithoutMed ? 'block' : 'none';
                    }

                    function showPopup(id) {
                        document.getElementById('popupOverlay').style.display = 'flex';
                        document.getElementById('id').value = id;
                    }

                    function hidePopup() {
                        document.getElementById('popupOverlay').style.display = 'none';
                    }

                    window.onload = function() {
                        toggleMedSection();
                    };
                </script>"

            ?>



        </tbody>
    </table>
</main>