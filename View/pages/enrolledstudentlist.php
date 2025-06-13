<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
include('../components/body.php');

?>

<main class="uppercase mt-22 px-8.5">

    <form style="border: 1px solid;" action="../../Controller//uploadStudent.php" method="POST" enctype="multipart/form-data">
        <h1>UPLOADING STUDENT's RECORDS</h1>

        Sheet must contains (col count) column <br>
        <p>EXAMPLE <br>
        <table style="border:1px solid">
            <tr style="border:1px solid">
                <th style="border:1px solid">firstname</th>
                <th style="border:1px solid">lastname</th>
                <th style="border:1px solid">LRN</th>
            </tr>
            <tr>
                <td style="border:1px solid">Juan</td>
                <td style="border:1px solid">Dela Cruz</td>
                <td style="border:1px solid">0001</td>
            </tr>
        </table>
        </p>
        <input type="file" name="file" required>
        <button
            class="bg-primary poppins   mt-5 w-1/3 justify-center cursor-pointer text-white px-5 py-3 flex gap-x-3 rounded-lg"
            type='submit' name="upload">Upload</button>
    </form>

    <table class="w-full poppins">
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