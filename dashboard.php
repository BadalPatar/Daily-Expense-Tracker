<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {

    echo "<h2 style='text-align:center;'>The connection failed. Please provide proper local server details and keep the files in the HTDOCS of localhost.<br>In case you want to See the design demo, <a href='demo.html' style='color:green;'>Please Visit Here</a></h2>";
    die("Connection failed: " . $conn->connect_error);
} 
$today = date("d/m/Y");

$sql = "SELECT id, amount, comment, day, type FROM expense ORDER BY day DESC, type ASC ";
$result = $conn->query($sql);

$sql0 = "SELECT id, amount, comment, day, type FROM expense WHERE day = '$today' ORDER BY type ASC ";
$result0 = $conn->query($sql0);


// adding expenses for that current day with all sorted catogeries

$money =  array("Grocery"=>0, "Entertainment"=>0, "Vehicle"=>0, "Food"=>0, "Miscellaneous"=>0,"total"=>0);
$sql2 = "SELECT amount, type FROM expense WHERE day = '$today'";
$result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $k = $row["type"];
            $money[$k] = $money[$k]+$row["amount"];
            $money["total"]= $money["total"] + $row["amount"];
        }
    }
    else {
        echo 'fao';
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>Daily Expense Manager</title>

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fafbfc;
            color: #636b6f;
            font-family: Open Sans, sans-serif;
            /*font-family: 'Raleway', sans-serif;*/
            font-weight: 300;
            height: 100vh;
            margin: 0;
            overflow: auto;
        }
        a {
            text-decoration: none;
        }
        .content {
            margin: 0;
            width: 100%;
            position: relative;
            top: 15vh;
            /*border: 2px solid red;*/
            /*text-align: center;*/
        }
        .title {
            font-size: 2em;
        }
        .header {

            z-index: 1;
            background: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            /*font-size: 1.25rem;*/
            color: #525c65;
            box-shadow: 0 1px 20px 0 rgba(46, 61, 73, .2);
        }
        ul {
            margin-bottom: 0;
        }
        .left {
            width: 20%;
            float: left;
            margin-top: 0;
        }
        
        .right {
            float: right;
            padding-right: 5vw;
            margin-top: 0;
        }
        .tabb li {
            float: right;
            list-style-type: none;
            padding: 20px;
        }
        .tabb li p {
            margin: 0;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            padding-right: 5px;
            padding-left: 5px;
        }
        .btnB {
            background: #02ccba;
            color: white;
            /*width: 7.75rem;*/
            box-shadow: 8px 10px 20px 0 rgba(46, 61, 73, .15);
            text-transform: capitalize;
            border-radius: 5px;
            margin: 0;
            padding: 10px;
            text-align: center;
            cursor: pointer;

        }
        
        #btnB {
            padding-right: 20px;
            padding-left: 20px;
        }
        
        .btnB:hover {
            box-shadow: 2px 4px 8px 0 rgba(46, 61, 73, .2);
        }
        
        .total {
            width: 100%;
            margin: auto;
        }
        
        .six {
            width: 100%;
            float: left;
            padding-top: 5vh;
            padding-bottom: 5vh;
            background: #fafbfc
        }
        
        .lapi {
            display: none;
        }
        
        .mobi {
            display: block;
        }
        
        .hamburger {
            display: block;
        }
        
        @media(min-width: 62em) {
            .lapi {
                display: block;
            }
            .mobi {
                display: none;
            }
            .six {
                width: 50%;
                float: left;
                padding-top: 5vh;
                padding-bottom: 5vh;
                background: #fafbfc
            }
        }
        
        #piechart {
            box-shadow: 5px 5px 25px 0 rgba(46,61,73,.2);
            background: white;
            margin: 3vh;
            padding: 40px;
            text-align: center;
            padding-top: 0;
            border-radius: .375rem;
        }
        #piechart:hover{
          cursor: pointer;
          box-shadow: 2px 4px 8px 0 rgba(46,61,73,.2);
        }

        .boxx{
          color: black;margin: 3vh;padding: 40px;background: white;
          box-shadow: 5px 5px 25px 0 rgba(46,61,73,.2);
          border-radius: .375rem;
          text-align: center;
        }
        .boxx:hover{
          cursor: pointer;
          box-shadow: 2px 4px 8px 0 rgba(46,61,73,.2);
        }

        
        input {
            margin-bottom: 20px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 2px;
            font-size: .9em;
        }
        
        select {
            margin-bottom: 20px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 2px;
            font-size: .9em;
        }
    </style>
</head>

<body>
    <div class="header">
        <ul class="left tabb">
            <li style="float: left;padding-left: 0;">

                <b style="margin: 0;
                    padding: 10px;
                    text-align: center;
                    cursor: pointer;
                    padding-right: 5px;
                    padding-left: 5px;" class="lapi"> <a href="dashboard.php" style="text-decoration: none;color: #525c65">
                    Daily Expense Tracker
               </a></b>
                <b class="mobi" style="
                    margin: 0;
                    padding: 10px;
                    text-align: center;
                    cursor: pointer;
                    padding-right: 5px;
                padding-left: -15px;"><a href="/" style="text-decoration: none;
                color: #525c65;">Manager</a></b>

            </li>
        </ul>
        <ul class="right tabb">

            <li>
                <a href="logout.php" style="text-decoration: none;color: #525c65">
                    <p class="btnB" id="btnB">Logout</p>
                </a>
            </li>

            <li>
                <a href="yearReport.php" style="text-decoration: none;color: #525c65">
                    <p class="btnB" id="btnB">Year Report</p>
                </a>
            </li>

            <li>
                <a href="report.php" style="text-decoration: none;color: #525c65">
                    <p class="btnB" id="btnB">My Reports</p>
                </a>
            </li>
            
        </ul>
    </div>

    <div class="content">

        <div class="total">
            <div class="six">
                <div class="boxx">

                    <div style="width: 100%;margin: auto;">
                        <div>
                            <div class="">
                                <div class="box-header" style="    background-color: #02b3e4;
                                    margin-top: 0;
                                    border-radius: 5px 5px 0 0;">
                                    <h2 style="text-transform: uppercase;
                                        color: white;
                                        font-weight: 400;
                                        letter-spacing: 1px;
                                        font-size: 1.4em;
                                        line-height: 2.8em;
                                    ">Add new Expenses</h2>
                                </div>
                                <p style="text-align: left;">Keep up to dated with your expenses by adding each in its respective catogaries and get weekly and monthly reports about your expenses.</p>

                                <form id="form-work" class="" name="form-work" action="success.php" method="POST" style="text-align: left;">
                                    

                                    <label for="catogery" style="padding-right: 20px;">Select Expense Catogery</label>

                                    <select type="text" id="catogery" name="type" required="true">
                                        <option value="">SELECT</option>
                                        <option value="Grocery">Grocery</option>
                                        <option value="Entertainment">Entertainment,</option>
                                        <option value="Vehicle">Vehicle</option>
                                        <option value="Food">Food</option>
                                        <option value="Miscellaneous">miscellaneous</option>
                                    </select>
                                    <br/>
                                    <label for="expense" style="padding-right: 20px;">Add your Expenses</label>
                                    <input type="number" id="expense" name="expense" required placeholder="How many did you spent">

                                     <br/>
                                    <label for="comment" style="padding-right: 20px;">Comment about expense</label>
                                    <input type="text" id="comment" name="comment" required placeholder="just to remember">
                                    <br/>
                                    <button type="submit" class="btn btnB" style="padding-right: 20px;
                                    padding-left: 20px;    box-shadow: 8px 10px 20px 0 rgba(46, 61, 73, .15);border: none;background-color: #02b3e4;font-size: 105%;">Add</button>
                                    <br/>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="six">
                <div id="piechart" style="width: 100%; height: 400px;"></div>
            </div>


<!-- Of that day -->

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <h2 class="text-center">Your total Expenses for Today</h2>
          <thead>
            <tr>
              <th style="background-color: #02b3e4;color: white;border-color: white">Amount</th>
              <th style="background-color: #02b3e4;color: white;border-color: white">Category</th>
              <th style="background-color: #02b3e4;color: white;border-color: white">Comments</th>
              <th style="background-color: #02b3e4;color: white;border-color: white">Actions</th>
            </tr>
            </thead>
                <tbody>
                    <?php
                        if ($result0->num_rows > 0) {
                            while ($row = $result0->fetch_assoc()) {
                                echo "<tr><td>" . $row["amount"] .
                                    "</td><td>"
                                    . $row["type"] . "</td><td>"
                                    . $row["comment"] . "</td><td>"
                                    . "<button class='edit-btn' data-id='" . $row["id"] . "'>Edit</button>"
                                    . "<button class='delete-btn' data-id='" . $row["id"] . "'>Delete</button>"
                                    . "</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div><!--end of .table-->
        </div>
    </div>
</div>





<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <h2 class="text-center">Your total Expenses</h2>
          <thead>
            <tr>
              <th style="background-color: #02b3e4;color: white;border-color: white ">Amount</th>
              <th style="background-color: #02b3e4;color: white;border-color: white ">Category</th>
              <th style="background-color: #02b3e4;color: white;border-color: white ">Comments</th>
              <th style="background-color: #02b3e4;color: white;border-color: white ">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["amount"]. 
                        "</td><td>"
                        . $row["type"]."</td><td>"
                        . $row["comment"]."</td><td>"
                        . $row["day"]."</td></tr>";
                    }
                }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-center"> This information is visible to everyone, for secure your data, Please create Login in</td>
            </tr>
          </tfoot>
        </table>
      </div><!--end of .table-->
    </div>
  </div>
</div>












    </div>

    <script>
        // Edit button click handler
        document.querySelectorAll('.edit-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                // Assuming you want to redirect the user to an edit page with the expense id
             window.location.href = 'edit_expense.php?id=' + id;
            });
        });

        // Delete button click handler
        document.querySelectorAll('.delete-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                // Remove the row from the table
               window.location.href = 'delete_expense.php?id=' + id; 
            });
        });
    </script>




    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Expenses', 'Rs per Day'],
                ['Grocery,', <?php echo $money['Grocery'] ?>],
                ['Entertainment,', <?php echo $money['Entertainment'] ?>],
                ['Vehicle,', <?php echo $money['Vehicle'] ?>],
                ['Food,', <?php echo $money['Food'] ?>],
                ['Miscellaneous', <?php echo $money['Miscellaneous'] ?>]
            ]);

            // Optional; add a title and set the width and height of the chart
            var options = {
                'title': 'Expenses by Category, Total Rs:<?php echo $money['total'] ?> ',
                'width': '100%',
                'height': '100%'
            };

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>

</body>

</html>
