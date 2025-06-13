<?php

include('../components/body.php');

?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
} else {
    include('../../config/database.php');

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];


    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM visitor WHERE firstname = ? AND lastname = ? ");
        $stmt->bind_param("ss", $firstname, $lastname);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = htmlspecialchars($row['count']);
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!-- navvvvvvvvvvv -->
<header
    class="bg-primary flex krona text-3xl justify-between px-7 py-4.5 items-center text-white md:hidden">
    <img
        id="home-btn"
        class="size-12 cursor-pointer"
        src="../assets/icons/school-icon.svg"
        alt="" />

    <h1 id="home-btn" class="cursor-pointer">MyRi Clinic</h1>

    <img
        id="menu-btn"
        class="z-21 size-9 cursor-pointer invert"
        src="../assets/icons/menu-icon.svg"
        alt="menu-btn" />
</header>
<nav
    id="SideBar"
    class="z-20 w-62 md:sm:w-24 lg:w-72 md:h-dvh xl:lg:w-82 translate-x-[50rem]  drop-shadow-2xl md:drop-shadow-none h-dvh md:translate-x-0 fixed duration-500 right-0 top-[-17px] md:top-0 md:left-0 md:block">
    <main
        class="grid text-white h-[70%] grid-rows-[100px_1fr_60px] md:h-dvh ">
        <section
            class="row-start-1 invisible md:visible cursor-pointer shadow-2xl bg-secondary flex items-center justify-center text-2xl krona">
            <img
                class="md:block size-12 lg:hidden"
                src="../assets/icons/school-icon.svg"
                alt="school-img" />
            <h1 class="md:hidden text-3xl lg:block">MyRi Clinic</h1>
        </section>

        <!-- navlinks -->
        <section
            class="poppins uppercase row-start-2 bg-primary flex gap-y-3 flex-col  px-3 py-4 text-lg">
            <!-- studnet info -->
            <a
                class="flex gap-x-4 px-3.5 py-3.5 leading-6 bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
                href="../pages/userformview.php">
                <img src="../assets/icons/stud-info-icon.svg" alt="visitor-icon" />
                <p class="md:hidden lg:block">My Medical Form</p>
            </a>
            <a
                class="flex gap-x-4 px-3.5 py-3.5 leading-6 bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
                href="../pages/userhistory.php">
                <img src="../assets/icons/stud-info-icon.svg" alt="visitor-icon" />
                <p class="md:hidden lg:block">My History</p>
            </a>
            <section class="mt-auto">

                <hr class="text-[#f5f5f565]  w-full">
                <a
                    class="flex gap-x-4 px-3.5 py-3.5 leading-6 rounded-lg md:flex md:justify-center lg:justify-start mt-3 hover:bg-[#ffffff1f]"
                    href="../pages/userprofile.php">
                    <img src="../assets/icons/user-icon.svg" alt="user-icon" />
                    <p class="md:hidden lg:block"><?php echo $_SESSION['user_role'] . "<br>" . $firstname . " " . $lastname ?></p>
                </a>
            </section>
        </section>
        <section
            class="rounded-bl-2xl md:rounded-none row-start-3 bg-secondary poppins uppercase px-5 py-3.5 flex text-lg w-full items-center gap-x-5">

            <!-- logout -->
            <form action="../../Controller/logout.php" method="POST">
                <button
                    id="logout-btn"
                    type="submit"
                    name="submit"
                    class="flex gap-x-4 px-3.5 py-3.5 leading-6 rounded-lg md:flex md:justify-center lg:justify-start cursor-pointer"
                    href="../pages/index.php"><img src="../assets/icons/exit-icon.svg" alt="inforamation-icon" />
                    <p class="md:hidden lg:block">logout</p>
                </button>
            </form>
        </section>
    </main>
</nav>
<!-- navvvvvvvvvvv -->


<main
    class="uppercase mt-22 px-8.5 ">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>Visit ID</th>
                <th>Name of student</th>
                <th>grade and section</th>
                <th>complaint</th>
                <th>TIME IN</th>
                <th>RELEASE</th>
                <th>DATE</th>
                <th>Treatment</th>
                <th>Qty.</th>
            </tr>

        </thead>


        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include("../../config/database.php");

            $firstname = $_SESSION['firstname'];
            $lastname = $_SESSION['lastname'];


            try {
                $stmt = $conn->prepare("SELECT * FROM visitor where firstname =? AND lastname =?");
                $stmt->execute([$firstname, $lastname]);
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                        $_firstname = htmlspecialchars($row['firstname']);
                        $_lastname = htmlspecialchars($row['lastname']);

                        echo "<tr class=''>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
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
                    echo "<tr>";
                    echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "No Visit Records." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>

        </tbody>
    </table>
</main>

<script src="../script/scriptnavbar.js"></script>
</body>

</html>

<?php



?>