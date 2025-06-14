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


<main class="relative md:sm:ml-24   lg:ml-72 md:h-dvh xl:lg:ml-82">
    <section class="relative mt-5 text-[max(3vw,2rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
            Enrolled Student's
        </h1>
        <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
    </section>

    <section class="flex items-center justify-between my-5  mx-8.5">
        <form
            class="flex gap-5"
            action="../../Controller/search.php"
            method="POST">

            <!-- name of student  -->

            <section class="relative basis-xs ">

                <label
                    id="label"
                    class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
                    for="name">name of student</label>

                <input
                    id="fullname"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="fullname"
                    placeholder="Dela Cruz, Juan"
                    type="text" />

            </section>


            <!-- search button  -->
            <section
                class="poppins text-white bg-primary  rounded-lg relative cursor-pointer">
                <button
                    action="submit"
                    name="submit"
                    class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Search</p>
                    <img clas src="../assets/icons/search-icon.svg" alt="" />
                </button>
            </section>
        </form>
        <button
            id="file-upload"
            class="bg-primary relative text-white  poppins z-20 w-1/3 justify-center cursor-pointer border-1 px-5 py-3 flex gap-x-3 rounded-lg">
            Upload a file
            <img src="../assets/icons/file-upload-icon.svg" alt="">
        </button>
    </section>

    <div id="blur" class="fixed h-dvh backdrop-blur-xs top-0 bg-white/30 z-0 w-full"></div>

    <form id="upload" class="border-dotted absolute left-1/5 top-1/3 w-1/2  shadow-xl bg-white border-3 border-[#8080808e] rounded-lg  flex flex-col items-center justify-between p-10 " action="../../Controller//uploadStudent.php" method="POST" enctype="multipart/form-data">

        <img id="close" class="invert absolute z-10  top-1.5 right-1.5 cursor-pointer" src="../assets/icons/close-icon.svg" alt="close-icon">
        <table class="opacity-70 w-full  uppercase poppins mb-10">
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
                    <h1 id="file-choose" class="font-semibold text-2xl">Choose a File</h1>
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
            id="browse"
            class="poppins z-10 mt-5 w-1/3 justify-center cursor-pointer border-1 px-5 py-3 flex gap-x-3 rounded-lg"
            type='submit' name="upload">Browse</button>
    </form>
    <section class="relative mt-12">
        <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
    </section>
    <!-- end of upload <form action=""></form> -->
    <!-- end of upload <form action=""></form> -->
    <!-- end of upload <form action=""></form> -->


    <div class="px-8.5 ">
        <table class="w-full poppins ">
            <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22 ">
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

        </table>
    </div>
</main>
<script>
    const file_upload = document.getElementById("file-upload")
    const upload = document.getElementById("upload")
    const blur = document.getElementById("blur")
    const close = document.getElementById("close")
    const file_choose = document.getElementById("file-choose")
    const fileInput = document.getElementById("file")
    const browse = document.getElementById("browse")
    const allowedExtensions = ['xls', 'xlsx', 'xlsm', 'xltx', 'xltm'];
    let click = false
    upload.classList.add("hidden")
    blur.classList.add("hidden")
    file_upload.addEventListener("click", () => {
        if (!click) {
            upload.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            upload.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })

    close.addEventListener("click", () => {
        if (!click) {
            upload.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            upload.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            file_choose.textContent = fileInput.files[0].name;
            browse.textContent = 'Upload';

        } else {
            file_choose.textContent = 'Choose a File';

        }
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (!file) return;

        const fileName = file.name.toLowerCase();
        const fileExt = fileName.split('.').pop();

        if (!allowedExtensions.includes(fileExt)) {
            alert('Invalid file type. Please select an Excel file.');
            file.value = ' '; // clear input
        }
    });
</script>
</body>