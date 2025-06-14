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

  <section class="relative mt-5 text-[max(3vw,2rem)] ">
    <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
      Student Form's
    </h1>
    <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
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

    <a class="bg-[#06118e] text-nowrap text-white poppins uppercase flex justify-evenly gap-2.5 px-10 cursor-pointer py-2.5 rounded-lg"
      href="view-download.php">My downloads
      <img src="../assets/icons/my-download-icon.svg" alt="my-download-icon">
    </a>
  </form>
  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>

  <?php

  include('../components/studentlist.php');

  ?>
</section>
</body>

</html>