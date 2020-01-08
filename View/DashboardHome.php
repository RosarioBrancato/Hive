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
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Expences This Month</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>$40,000</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>reminders left this Month</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>$215,000</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-bell fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Pending &nbsp;Paiyments</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>18</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-tasks fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-primary shadow">
                    <div class="card-body">
                        <p class="m-0">Household</p>
                        <p class="text-white-50 small m-0">23</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-success shadow">
                    <div class="card-body">
                        <p class="m-0">Health</p>
                        <p class="text-white-50 small m-0">21</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-info shadow">
                    <div class="card-body">
                        <p class="m-0">Freetime</p>
                        <p class="text-white-50 small m-0">14</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-warning shadow">
                    <div class="card-body">
                        <p class="m-0">Education</p>
                        <p class="text-white-50 small m-0">3</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <p class="m-0">Important</p>
                        <p class="text-white-50 small m-0">33</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card text-white bg-secondary shadow">
                    <div class="card-body">
                        <p class="m-0">low priority</p>
                        <p class="text-white-50 small m-0">11</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-xl-8">

                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary font-weight-bold m-0">Document Types Share</h6>

                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas data-bs-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Direct&quot;,&quot;Social&quot;,&quot;Referral&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;50&quot;,&quot;30&quot;,&quot;15&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{}}}"></canvas></div>
                        <div class="text-center small mt-4"><span class="mr-2"><i class="fas fa-circle text-primary"></i>&nbsp;Type A</span><span class="mr-2"><i class="fas fa-circle text-success"></i>Type B</span><span class="mr-2"><i class="fas fa-circle text-info"></i>&nbsp;Type C</span></div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary font-weight-bold m-0">Document Types Share</h6>

                    </div>
                    <div id="test" class="box"></div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">Upcoming Dues</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>Assura Insurance - Reminder</strong></h6><span class="text-xs">Today</span></div>
                                <div class="col-auto"><i class="fa fa-clock-o"></i></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>FHNW Invoice - Due</strong></h6><span class="text-xs">18.12.2019</span></div>
                                <div class="col-auto"><i class="fa fa-thumb-tack"></i></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <h6 class="mb-0"><strong>Phone abonament - Due</strong></h6><span class="text-xs">31.12.2019</span></div>
                                <div class="col-auto"><i class="fa fa-thumb-tack"></i></div>
                            </div>
                        </li>
                    </ul>

            </div>

                <div class="col-lg-6 mb-4">

                </div>
        </div>


    </div>
</div>

    <script>
        anychart.onDocumentReady(function() {

            // set the data
            var data = [
                {x: "A", value: 22},
                {x: "B", value: 33},
                {x: "C", value: 11},
                {x: "D", value: 54},
                {x: "E", value: 34},
                {x: "F", value: 44},
                {x: "G", value: 35}
            ];


            // create the chart
            var chart = anychart.pie();

            // set the chart title
            //chart.title("Test");

            // add the data
            chart.data(data);

            // display the chart in the container
            chart.container('test');

            chart.draw();

        });
    </script>