<main
  class="uppercase mt-22 px-8.5 ">
  <table class="w-full poppins">
    <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
      <tr>
        <th>Preview</th>
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

      try {
        $query = "SELECT * FROM visitor where checkout != '' order by _date desc , checkin asc";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {

          while ($row = $result->fetch_assoc()) {
            $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
            $_firstname = htmlspecialchars($row['firstname']);
            $_lastname = htmlspecialchars($row['lastname']);

            echo "<tr class=''>";
            echo "<td>
        <form action='../../Controller/studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        <button type='submit' name='view-history'><span style='color: green;'>View History</span></button>
                        </form>
            </td>";

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
          echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "No Current Patient." . "</td>";
          echo "</tr>";
        }
      } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>

    </tbody>
  </table>
</main>