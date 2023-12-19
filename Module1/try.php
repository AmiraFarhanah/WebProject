   
<?php
    session_start();
    include("config.php");
    
    
?>

   <?php
   
   
   $queryAdmin = "SELECT ID, Username, Name, Email, Usergroup FROM administrator";
   $resultAdmin = mysqli_query($con, $queryAdmin);
   
   $queryVendor = "SELECT ID, Username, Name, Email, Usergroup FROM food_vendor";
   $resultVendor = mysqli_query($con, $queryVendor);
   
   
   $queryRegisteredUser = "SELECT ID, Username, Name, Email, Usergroup FROM registered_user";
   $resultRegisteredUser = mysqli_query($con, $queryRegisteredUser);
  
        // Step 3: Merge and sort the data based on ID
        $data = array();

        while ($row = $resultAdmin->fetch_assoc()) {
            $data[] = $row;
        }

        while ($row = $resultVendor->fetch_assoc()) {
            $data[] = $row;
        }

        while ($row = $resultRegisteredUser->fetch_assoc()) {
            $data[] = $row;
        }

        usort($data, function ($a, $b) {
            return $a['ID'] - $b['ID'];
        });

        // Step 4: Display the sorted data in a table

        echo "<style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
    
        .table-container {
            width: 70%;
            margin: 0 auto;
        }
    
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            text-align: left;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
    
        .styled-table th, .styled-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
    
        .styled-table th {
            background-color: #2c3e50;
            font-weight: bold;
            color: #ecf0f1;
        }
    
        .styled-table tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>";
    
    echo "<div class='table-container'>
    <table class='styled-table'>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>User group</th>
        </tr>";

foreach ($data as $row) {
    echo "<tr>
            <td>" . $row['ID'] . "</td>
            <td>" . $row['Username'] . "</td>
            <td>" . $row['Name'] . "</td>
            <td>" . $row['Email'] . "</td>
            <td>" . $row['Usergroup'] . "</td>
          </tr>";
}

echo "</table>
</div>";

   
   ?>