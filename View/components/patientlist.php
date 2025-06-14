<main
    class="uppercase mt-22 px-8.5 ">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>ID</th>
                <th>Name of studnet</th>
                <th>grade and section</th>
                <th>complaint</th>
                <th>status</th>
                <th>TIME IN</th>
                <th>DATE</th>
            </tr>
        </thead>
        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include("../../config/database.php");

            try {
                $query = "SELECT * FROM visitor where _date = CURDATE() order by checkin desc";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        if (htmlspecialchars($row['checkout']) == "") {
                            $status = "On Treatment";
                        } else {
                            $status = "Treated";
                        }

                        echo "<tr class=''>";
                        echo "<td >" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr '>";
                    echo "<td colspan='9' class='text-center bg-[#d4d4d40c]'>" . "No Current Patient." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>



        </tbody>
    </table>
</main>