<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>
<?php
include('../components/body.php');
include('../components/navbar.php');
?>

<section class="overflow-x-hidden md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82 px-5">

    <section class="relative py-7.5 pt-12">
        <h1 class="krona uppercase bg-white lg:ml-12 px-5 inline z-20 text-3xl">
            Medical Inventory
        </h1>
        <hr class="absolute z-[-1] w-full top-17" />

        <form
            action="../../Controller/addmeds.php"
            method="POST"
            class="px-8.5 gap-3.5 uppercase my-10 flex justify-center flex-wrap lg:flex-nowrap min-[200px]:w-[90%] ">


            <section class="relative basis-xm  ">
                <label
                    id="medicine"
                    class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
                    for="medicine">medicine name</label>

                <input
                    id="medicine_name"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="medicine_name"
                    type="text" />

            </section>
            <section class="relative basis-xm ">
                <label
                    id="medicine_qty"
                    class="absolute inline top-0 bg-white ml-2 px-1 leading-1"
                    for="medicine_qty">quantity</label>

                <input
                    id="medicine_qty"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="medicine_qty"
                    type="number" />
            </section>


            <section class="relative basis-xm">
                <label
                    id="expiration"

                    class="absolute inline top-0 bg-white ml-2 px-1 leading-1"
                    for="expiration">expiration date</label>
                <input
                    id="expiration"
                    required
                    class="border-1 py-2.5 px-4.5 rounded-lg w-full"
                    name="expiration"
                    type="date" />
            </section>

            <section
                class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
                <button
                    type="submit"
                    name="add"
                    class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Add</p>
                    <img class src="../assets/icons/check-icon.svg" alt="" />
                </button>
            </section>
        </form>
        <hr>

    </section>

    <table class="w-full poppins uppercase">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>Med ID</th>
                <th>medicine name</th>
                <th>quantity</th>
                <th>expiration date</th>
                <th>status of stock</th>
                <th>Issued</th>
                <th>Delete Medicine</th>
            </tr>
        </thead>
        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
            <?php
            include('../../config/database.php');
            $today = date("Y-m-d");
            try {
                $query = "SELECT * FROM meds order by Medicine_Name asc";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $_id = htmlspecialchars($row['id']);
                        $qty = htmlspecialchars($row['Med_Quantity']);



                        $epx = htmlspecialchars($row['Expiration_Date']);
                        echo "<tr>";
                        echo "<td>" . $_id . "</td>";
                        echo "<td>" . htmlspecialchars($row['Medicine_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Med_Quantity']) . "</td>";
                        if (htmlspecialchars($row['Expiration_Date']) <= $today) {
                            echo "<td>" . "<span style='color:red'>EXPIRED</span>" . "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($row['Expiration_Date']) . "</td>";
                        }
                        echo "<td><span style='color: " .
                            ($epx <= $today ? "red" : ($qty == 0 ? "orange" : "green")) . ";'>" .
                            ($epx <= $today ? "Unavailable" : ($qty == 0 ? "Out of stocks" : "Available")) .
                            "</span></td>";




                        echo "<td>" . htmlspecialchars($row['issued']) . "</td>";
                        echo "<td>" . "<form action='../../Controller/delete.php' method='POST'>
                        <input type='hidden' name='id' value='" . $_id . "'>
                        
                        <button type='submit' name='delete'><span style='color: red;'>Delete</span></button>
                        </form> " . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "No Medicine Found." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }

            ?>


        </tbody>
    </table>
    <br>

    <h1 class="krona uppercase bg-white lg:ml-12 px-5 inline z-20 text-3xl">CONSUMED</h1>
    <br>
    <hr>
    <table class="w-full poppins uppercase">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>Med ID</th>
                <th>medicine name</th>
                <th>quantity</th>
                <th>Last Date of Use</th>


            </tr>
        </thead>
        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
            <?php
            include('../../config/database.php');
            $today = date("Y-m-d");
            try {
                $query = "SELECT * FROM used_meds order by Medicine_Name asc";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $_id = htmlspecialchars($row['id']);
                        echo "<tr>";
                        echo "<td>" . $_id . "</td>";
                        echo "<td>" . htmlspecialchars($row['Medicine_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Med_Quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Date_Consumed']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "No Medicine Found." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }

            ?>


        </tbody>
    </table>
</section>

</body>

</html>