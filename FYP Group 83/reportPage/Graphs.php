<?php
include 'db.php';
?>
<html>
    <h1>Yearly Sales Graph</h1>
    Year
   <select class="form-control" name="companyName" placeholder="Select Year" >
                        <?php
                        if (!$stmt = $conn->prepare("SELECT invoice_date FROM customer_invoice")) {
                            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                        }
                     // Execute it /
                        $stmt->execute();
                        $stmt->bind_result($invoice_date);
                        // output data of each row
                        ?>
                         <option value="-1">Select a date</option> 
                         <?php
                        while ($row = $stmt->fetch()) {
                            if (!$row == 0) {
                                ?>
                       
                                <option value="<?php echo $invoice_date; ?> ">
                                    <?php echo "" . $invoice_date . ""; ?>
                                </option>  
                                <?php
                            }
                        }
                        $conn->close();
                        ?>

                    </select>
    <button type="button">Go</button>
    <link rel="stylesheet" type="text/css" href="morris.css">


    <script type="text/javascript" language="javascript" src="jquery-1.11.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="morris.min.js"></script>
    <script type="text/javascript" language="javascript" src="raphael-min.js"></script>


    <div id="myfirstchart"></div>

    <script>
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'myfirstchart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
                {year: '2008', value: 20000},
                {year: '2009', value: 10000},
                {year: '2010', value: 50000},
                {year: '2011', value: 30000},
                {year: '2012', value: 7000}
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'year',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value']
        });


    </script>
</html>