  <?php
          const servername = "localhost";
          const username = "root";
          const password = "";
          const dbname = "Blog";

        $conn = mysqli_connect(servername, username, password, dbname) or   die("Connection failed: " . mysqli_connect_error());
  ?>