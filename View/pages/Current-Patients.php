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
<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">
    <section class="relative mt-5 text-[max(3vw,2rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
            Current Patient's
        </h1>
        <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
    </section>


    <!-- visitor form  -->
    <form
        action="../../Controller/search.php"
        method="POST"
        class="px-8.5 mt-5 gap-3.5 uppercase flex justify-center flex-wrap lg:flex-nowrap min-[200px]:w-[90%]">

        <!-- name of student  -->

        <section class="relative  basis-xs ">

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


        <!-- submit button  -->
        <section
            class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
            <button
                action="submit"
                name="submit"
                class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                <p>Search</p>
                <img clas src="../assets/icons/search-icon.svg" alt="" />
            </button>
        </section>
    </form>

    <!--  -->
    <!--  -->
    <section class="relative mt-12">
        <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
    </section>
    <!--  -->
    <!--  -->
    <!-- visitor list components >>>>>>>>> -->
    <?php
    include('../components/currentpatients.php')
    ?>
</section>
</body>

</html>