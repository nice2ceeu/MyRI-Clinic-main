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

<main class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82 px-8.5">
    <form class="border-dotted relative border-3 border-[#8080808e] rounded-lg  flex flex-col items-center justify-between p-5  " action="../../Controller//uploadStudent.php" method="POST" enctype="multipart/form-data">
        <table class="opacity-70 w-full z-[-1] uppercase poppins mb-10">
            <tr class="border-1">
                <th class="text-sm" colspan="4"> excel must contains</th>
            </tr>
            <tr class="[&>th]:border-1">
                <th>firstname</th>
                <th>lastname</th>
                <th>LRN</th>
            </tr>
            <tr class="text-center [&>td]:border-1">
                <td>Juan</td>
                <td>Dela Cruz</td>
                <td>11 Digit No.</td>
            </tr>
        </table>
        <img class="size-7 opacity-70" src="../assets/icons/upload-icon.svg" alt="upload-icon" />
        <div class="h-full w-full  absolute">
            <label for="file">
                <div class="flex flex-col items-center pt-40">
                    <h1 class="font-semibold text-2xl">Choose a File</h1>
                    <h6 class="opacity-80 text-sm">XLS, XLSX, XLSM, XLTX and XLTM</h6>
                </div>
                <input class="absolute opacity-0 top-[-20px] focus:opacity-0 h-full w-full" id="file" type="file" name="file" required>
            </label>
        </div>
        <br>
        <br>
        <br>
        <br>
        <button
            class="poppins z-10 mt-5 w-1/3 justify-center cursor-pointer border-1 px-5 py-3 flex gap-x-3 rounded-lg"
            type='submit' name="upload">Upload</button>
    </form>

    <table class="w-full poppins ">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr class="">

                <th>ID</th>
                <th>FULL NAME</th>
                <th>Username<br>(LRN)</th>
                <th>Account Status</th>
                <th>Reset Password</th>
            </tr>
        </thead>
        <tbody
            class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <body>
                <?php
                include("../../config/database.php");
                try {
                    $query = "SELECT * FROM admin where user_role = 'student' order by lastname asc";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            if (htmlspecialchars($row['password']) == "") {
                                $registered  = "<span style='color:red'>Not Registered</span>";
                            } else {
                                $registered = "<span style='color:green'> Registered</span>";
                            }
                            $id = htmlspecialchars($row['id']);
                            echo "<tr class=''>";
                            echo "<td>" . $id . "</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . " " . htmlspecialchars($row['firstname']) .   "</td>";
                            echo "<td>" . htmlspecialchars($row['username'])  . "</td>";


                            echo "<td>" . $registered . "</td>";
                            if (htmlspecialchars($row['password']) === '' || htmlspecialchars($row['password']) === null) {
                                echo "<td>Unavailable</td>";
                            } else {
                                echo "<td>" .
                                    "<form action='../../Controller/resetpassword.php' method='POST'>
                                    <input type='hidden' name='id' value='$id'>
                                    <button type='submit' name='reset'>RESET PASSWORD</button>
                                </form></td>";
                            }

                            echo "</tr>";
                        }
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }

                ?>
            </body>
    </table>






</main>