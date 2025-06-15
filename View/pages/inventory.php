<?php
session_start();

include("../../View/modal/alert.php");
if (isset($_SESSION['modal_message'])) {
    $msg = $_SESSION['modal_message'];
    $title = $_SESSION['modal_title'] ?? 'Notice';

    echo "<script>
    document.getElementById('alertHeader').innerText = '$title';
    showModal('$msg');
  </script>";
    unset($_SESSION['modal_message'], $_SESSION['modal_title']);
}


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>
<?php
include('../components/body.php');
include('../components/navbar.php');
?>

<section class="md:sm:ml-24 relative  lg:ml-72 md:h-dvh xl:lg:ml-82 overflow-x-hidden uppercase">


    <section class="relative mt-5 text-[max(3vw,2rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
            Medicine Inventory
        </h1>
        <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
    </section>
    <section>
        <form
            action="../../Controller/addmeds.php"
            method="POST"
            class="px-8.5 gap-3.5  uppercase my-10 flex justify-left flex-wrap lg:flex-nowrap min-[200px]:w-[90%] ">


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

            <section
                class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
                <button
                    id="view-comsume"
                    class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p class="text-nowrap">view comsume</p>
                    <img class src="../assets/icons/view-icon.svg" alt="" />
                </button>
            </section>
        </form>
        <section class="relative mt-12">
            <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
        </section>





        <!-- sort section -->

        <section class="poppins uppercase place-self-left py-3.5 mx-8.5">
            <form class=" flex items-center flex-wrap gap-5" action="">


                <div class="relative">
                    <label
                        id="label"
                        class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
                        for="complaint">
                        expiration
                    </label>
                    <select name="accountStatus" id="complaint" class="border rounded px-7.5 py-1.5">
                        <option disabled selected>Select to filter</option>
                        <option value="expired">Expired</option>
                        <option value="inEffect">In Effect</option>
                    </select>
                </div>

                <div class="relative">
                    <label
                        id="label"
                        class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
                        for="complaint">
                        Stock Status
                    </label>
                    <select name="accountStatus" id="complaint" class="border rounded px-7.5 py-1.5">
                        <option disabled selected>Select to filter</option>
                        <option value="Available">Available</option>
                        <option value="unavailable">Unavailable</option>
                        <option value="out_of_stocks">Out of stocks</option>
                    </select>
                </div>


                <button
                    name="filter"
                    class="uppercase bg-primary text-white rounded-lg py-2 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Filter</p>
                    <img clas src="../assets/icons/filter-icon.svg" alt="" />
                </button>
            </form>
        </section>



    </section>
    <div
        class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
        <table class="min-w-full poppins">
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
                            
                        <button class='flex rounded-lg gap-5 px-7 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete'><span '>Delete</span> </button>
                        </form> " . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='9' class='text-center bg-[#d4d4d40c]'>" . "No Medicine Found." . "</td>";
                        echo "</tr>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }

                ?>

            </tbody>
        </table>

    </div>
    <div id="blur" class="fixed  h-full backdrop-blur-xs top-[-20px] bg-white/30 z-0 w-full"></div>

    <div id="consumed-medicine" class="absolute top-1/4 w-[80%] right-1/8 shadow-xl z-10 p-5   bg-white">
        <img id="close" class="invert absolute top-2  right-2 cursor-pointer" src="../assets/icons/close-icon.svg" alt="">
        <section class=" relative mt-5 text-[min(4vw,2rem)] ">
            <h1 class=" poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
                Consumed medicine
            </h1>
            <hr class=" absolute z-[-1] text-[#acacac] top-1/2 w-full" />
        </section>
        <table class="w-full poppins uppercase mt-10">
            <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-12">
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
    </div>

</section>

</body>
<script>
    const view = document.getElementById("view-comsume")
    const container = document.getElementById("consumed-medicine")
    const blur = document.getElementById("blur")
    const close = document.getElementById("close")
    let click = false
    container.classList.add("hidden")
    blur.classList.add("hidden")

    view.addEventListener("click", (e) => {
        e.preventDefault()
        if (!click) {
            container.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            container.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })





    close.addEventListener("click", () => {

        if (!click) {
            container.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            container.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })
</script>

</html>