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
  <section class="relative py-7.5 pt-12">
    <h1 class="poppins uppercase bg-white lg:ml-12 px-5 inline z-20 text-3xl">
      Visitor History
    </h1>
    <hr class="absolute z-[-1] w-full top-17" />
  </section>


  <!-- <form action="" method="POST">

    <section class="relative w-full">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="Sorter">Sort By: </label>
      <select class="border-1 rounded-lg py-2.5 w-300px px-4.5" name="Sorter" id="">
        <option value="7">Name</option>
        <option value="8">Time In</option>
        <option value="9">Time Out</option>
        <option value="10">Date</option>
      </select>
    </section>
    <br>
    <section class="relative">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="search">SEARCH</label>
      <input
        id="search"
        class="border-1  py-2.5 w-300px px-4.5 rounded-lg m-20px"
        type="text" />
    </section>
    <br>
    <section
      class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
      <button
        action="submit"
        name="submit"
        class="uppercase  py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>SEARCH</p>
        <img clas src="../assets/icons/search-icon.svg" alt="" />
      </button>
    </section>

  </form>
  <hr> -->

  <?php
  include('../components/visitorlist.php');
  ?>
</section>
</body>

</html>