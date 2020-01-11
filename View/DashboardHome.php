<?php

use View\View;

$name = View::NoHTML($this->agent->getName());

?>
<div class="container">
    <h1>Dashboard Home</h1>
    <p>Welcome <?php echo $name; ?></p>
    <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new'; ?>" class="btn btn-info">Add Document</a>

    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Overview</h3></div>
        <div class="row">
            <div class="col-lg-7 col-xl-8">

                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary font-weight-bold m-0">Document Types Share</h6>

                    </div>
                    <div id="test" class="chart-area"></div>
                </div>

                <!--<div class="col-lg-6 mb-4">

                    TABLE WITH DOCUMENT DATA
        </div>-->


    </div>

</div>

    <script>
        anychart.onDocumentReady(function() {

            $.ajax({url: "<?php echo $GLOBALS["ROOT_URL"] . "/dashboard/statistics"; ?>",
                success: function(result){
                    console.log(result);
                    var data = JSON.parse(result);

                    // create the chart
                    var chart = anychart.pie();

                    // set the chart title
                    //chart.title("Test");

                    // add the data
                    chart.data(data);

                    // display the chart in the container
                    chart.container('test');

                    chart.draw();
                }});

            // set the data
            /*var data = [
                {x: "A", value: 22},
                {x: "B", value: 33},
                {x: "C", value: 11},
                {x: "D", value: 54},
                {x: "E", value: 34},
                {x: "F", value: 44},
                {x: "G", value: 35}
            ];*/




        });
    </script>