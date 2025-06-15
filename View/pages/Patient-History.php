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
      Visitor History
    </h1>
    <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
  </section>


  <form
    action="../../Controller/search.php"
    method="POST"
    class="mx-8.5 mt-5 gap-3.5 uppercase flex justify-left flex-wrap lg:flex-nowrap min-[200px]:w-[90%]">


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

  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>



  <!--  -->
  <!-- sort section -->
  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>
  <!--  -->


  <section class="poppins uppercase place-self-left py-3.5 mx-8.5">
    <form class=" flex items-center gap-5" action="">


      <div class="relative">
        <label
          id="label"
          class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
          for="complaint">
          Time of Day
        </label>
        <select name="filterDay" id="complaint" class="border rounded px-3.5 py-1.5">
          <option disabled selected>Select to filter</option>
          <option value="morning">Morning</option>
          <option value="afternoon">Afternoon</option>
          <option value="evening">Evening</option>
          <option value="night">Night</option>
        </select>
      </div>



      <div class="relative">
        <label
          id="label"
          class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
          for="complaint">
          grade
        </label>
        <input class="border-1 rounded px-3.5 py-1.5 w-22" type="number" name="studentGrade" id="">
      </div>


      <button
        name="submit"
        class="uppercase bg-primary text-white rounded-lg py-2 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>Filter</p>
        <img clas src="../assets/icons/filter-icon.svg" alt="" />
      </button>
    </form>
  </section>




  <?php
  include('../components/visitorlist.php');
  ?>
</section>
</body>

<script>
  sessionStorage.setItem("lastPage", window.location.href);
</script>

</html>