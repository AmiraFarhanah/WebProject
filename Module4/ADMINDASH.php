<?php
    session_start();
    include("config.php");
    
    
?>
<style>
     .container4 {
        margin-top: 20px;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container4 h2 {
        text-align: center;
        color: #black; /* Change this to a contrasting color */
    }

    #barChartContainer {
        width: 100%;
        height: 500px;
        
    }
    </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Pie Chart in Php</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        //<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <?php

   
   echo "var counts = [";
   echo "['User Type', 'Count'],";
   
   $queryAdmin = "SELECT COUNT(*) as count FROM administrator";
   $resultAdmin = mysqli_query($con, $queryAdmin);
   $countAdmin = mysqli_fetch_assoc($resultAdmin)['count'];
   echo "['Administrator', $countAdmin],";
   
   $queryVendor = "SELECT COUNT(*) as count FROM food_vendor";
   $resultVendor = mysqli_query($con, $queryVendor);
   $countVendor = mysqli_fetch_assoc($resultVendor)['count'];
   echo "['Food Vendor', $countVendor],";
   
   $queryRegisteredUser = "SELECT COUNT(*) as count FROM registered_user";
   $resultRegisteredUser = mysqli_query($con, $queryRegisteredUser);
   $countRegisteredUser = mysqli_fetch_assoc($resultRegisteredUser)['count'];
   echo "['Registered User', $countRegisteredUser]";
   
   echo "];";
   ?>

   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);

   function drawChart() {
      var data = google.visualization.arrayToDataTable(counts);

      var options = {
         title: 'User Types Distribution',
                backgroundColor: {
                fill: '#fbe3e8', // Set your desired background color
                stroke: '#d9d9d9', // Set the border color if needed
                strokeWidth: 0 // Set the border width if needed
    }
         
         
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
   }
</script>

</head>
<body>
    <div class="hero">
        <nav>
            <a href="home.php" class="logo"></a>      
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Feature</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <img src="login.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                
                    <div class="user-info">
                        <img src="login.png" style="margin-right: 10px;">
                        <h3>Hai Lat</h3> 


                    </div>
                    <hr>
                    <div>
                    <?php

                    $id=$_SESSION['valid'];
                    $query= mysqli_query($con, "SELECT * FROM administrator where ID='$id'");

                    $res_id=null;
                    while($result= mysqli_fetch_assoc($query)){
                        $res_name=$result['Administrator_Name'];
                        $res_username=$result['Administrator_Username'];
                        $res_password=$result['Administrator_Password'];
                        $res_address=$result['Administrator_Address'];
                        $res_email=$result['Administrator_EmailAddress'];
                        $res_phonenumber=$result['Administrator_PhoneNum'];
                        $res_id=$result['ID'];
                        $res_usertype=$result['Usertype'];
                        

                    }

                    echo "<a href='login.php' class='sub-menu-link'>
                        <img src='./icon/login.png'>
                        <p>Login</p>
                        <span>></span>

                    </a>";

                    


                    echo "<a href='register.php' class='sub-menu-link'>
                        <img src='./icon/signin.png' style='height: 40px; width: 40px;'>
                        <p>Sign In</p>
                        <span>></span>

                    </a>";

                   
                     echo "<a href='editadmin.php?Id=$res_id' class='sub-menu-link'>
                    <img src='./icon/edit.png' >
                    <p>Edit Profile</p>
                    <span>></span>
                    </a>";



                    

                    echo "<a href='logout.php' class='sub-menu-link'>
                        <img src='./icon/logout.png' >
                        <p>Log Out</p>
                        <span>></span>

                    </a>";

                    ?>
                    



                    </div>
                    

                </div>

            </div>

        </nav>
    </div>
    

    <div id="piechart" style="width: 900px; height: 500px;"></div>
<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

  //alya
 window.onload = function () {

//Better to construct options first and then pass it as a parameter
var Pieoptions = {
	title: {
		text: "Total in-store sales monthly "              
	},
	data: [              
	{
		// Change type to "doughnut", "line", "splineArea", etc.
		type: "column",
		dataPoints: [
			{ label: "January",  y: 1000  },
			{ label: "February", y: 900  },
			{ label: "March", y: 1500  },
			{ label: "April",  y: 800  },
			{ label: "May",  y: 1500  },
      { label: "June",  y: 1200  }
		]
	}
	]
};

$("#chartContainer").CanvasJSChart(Pieoptions);
}

    

</script>
</div>
<div class="container4" >
        <h2>Sales Bar Chart</h2>
        <div id="barChartContainer" style="width: 100%; height: 500px;"></div>
        <div id="chart"></div> </div>
<script>
    var options = {
          series: [{
          name: 'Inflation',
          data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + "%";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "%";
            }
          }
        
        },
        title: {
          text: 'Monthly Inflation in Argentina, 2002',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <br><br>
      </body>
      

</html>
