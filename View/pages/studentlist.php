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

<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82 uppercase">
  <section class="relative mt-10">
    <h1 class="krona text-3xl inline px-5 bg-white z-[10] ml-10">
      Student Forms list
    </h1>
    <hr class="absolute w-full top-[20px]  z-[-1]" />
  </section>

  <!-- FORM SEARCH SECTION FOR USERS  -->
  <form action="../../Controller/search.php" method="POST" class="w-1/2 relative mt-[30px] uppercase px-8.5 flex gap-7">
    <section class="relative w-full grow-1">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="name">full name</label>
      <input
        id="name"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="fullname"
        placeholder="Dela Cruz, Juan"
        type="text"
        required />
    </section>



    <button
      action="submit"
      name="search"
      class="bg-[#06118e] text-white poppins uppercase flex justify-evenly gap-2.5 px-10 cursor-pointer py-2.5 rounded-lg">
      <p>Search</p>

      <img src="../assets/icons/search-icon.svg" />
    </button>

    <a href="view-download.php">My downloads</a>
  </form>
  <hr class="w-full z-[-1] mt-[80px]" />

  <?php

  include('../components/studentlist.php');

  ?>
</section>
</body>

</html>