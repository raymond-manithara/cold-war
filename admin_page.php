<?php
session_start();
if(!isset($_SESSION["userId"])&&!isset($_SESSION["username"])){
    header("location:login.php");
}
// Database
require_once './connection.php';


if (isset($_POST['records-limit'])) {
    $_SESSION['records-limit'] = $_POST['records-limit'];
}

$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;
$orders = $connection->query("SELECT * FROM reg LIMIT $paginationStart, $limit")->fetchAll();

// Get total records
$sql = $connection->query("SELECT count(OrderId) AS OrderId FROM reg")->fetchAll();
$allRecrods = $sql[0]['OrderId'];

// Calculate total pages
$totoalPages = ceil($allRecrods / $limit);

// Prev + Next
$prev = $page - 1;
$next = $page + 1;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <title>PHP Pagination Example</title>
    <style>
        body {
            overflow-x: hidden;
        }

        .container {
            max-width: 1000px
        }

        .custom-select {
            max-width: 150px
        }

        .pagination>li>a {
            background-color: white;
            color: #5A4181;
        }

        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            color: #000000;
            background-color: #eee;
            border-color: #ddd;
        }

        .pagination>.active>a {
            color: white;
            background-color: #000000 !Important;
            border: solid 1px #000000 !Important;
        }

        .pagination>.active>a:hover {
            background-color: #000000 !Important;
            border: solid 1px #000000;
        }

        .row>.col-3>.nav {
            margin-top: 40%;
            height: 100%;
        }

        .width-const {
            width: 50%;
        }

        .nav-pills>.nav-item>.active {
            color: white !Important;
            background-color: #000000 !Important;
            border: solid 1px #000000 !Important;
            font-size: 14;
            font-weight: bold;
        }

        .nav-pills>.nav-item>a {
            color: #000000;
            text-align: center;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
<a class="navbar-brand text-light">Navbar</a>
<i class="fas fa-user text-light"></i>
</nav>
    <div class="row">
        <div class="col-3">
            <ul class="nav flex-column nav-pills md-3" id="myTab">
                <li class="nav-item" style="font-weight:bold;text-align:center">
                    Services
                </li>
                <li class="nav-item" style="font-weight:bold;text-align:center">
                <hr/>
                </li>
                
                <li class="nav-item">
                    <a href="#sectionA" class="nav-link active" data-toggle="tab"><i class="fas fa-tablet"></i>&nbsp;&nbsp;Console</a>
                </li>
                <li class="nav-item">
                    <a href="#sectionB" class="nav-link" data-toggle="tab"><i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;&nbsp;Orders</a>
                </li>
                <li class="nav-item">
                    <a href="#sectionC" class="nav-link" data-toggle="tab"><i class="fas fa-cogs"></i>&nbsp;Settings</a>
                </li>
            </ul>

        </div>


        <div class="tab-content col-9" >
            <div id="sectionA" class="tab-pane fade show active">
                <div class="container mt-5">
                    <h2 class="text-start mb-5">Console Overview</h2>
                    <div class="d-flex flex-row-reverse mt-3">
                        <div class="width-const">
                            <canvas id="lineChart"></canvas>
                        </div>
                        <div class="width-const">
                            <canvas id="barChart"></canvas>
                        </div>


                    </div>
                </div>
            </div>
            <div id="sectionB" class="tab-pane fade">
                <div class="container mt-5">
                    <h2 class="text-start mb-5">Orders Booking</h2>


                    <!-- Select dropdown -->
                    <div class="d-flex flex-row-reverse bd-highlight mb-3">
                        <form action="admin_page.php" method="post">
                            <select name="records-limit" id="records-limit" class="custom-select">
                                <option disabled selected>Records Limit</option>
                                <?php foreach ([3, 5, 7, 10, 12] as $limit) : ?>
                                    <option <?php if (isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?> value="<?= $limit; ?>">
                                        <?= $limit; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                        <div style="width: 20px;"></div>
                        <span>No of entries</span>
                    </div>

                    <!-- Datatable -->
                    <table class="table table-bordered mb-5" >
                        <thead>
                            <tr class="bg-dark text-light">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Team</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <th scope="row"><?php echo $order['OrderId']; ?></th>
                                    <td><?php echo $order['Name']; ?></td>
                                    <td><?php echo $order['Phone']; ?></td>
                                    <td><?php echo $order['Date']; ?></td>
                                    <td><?php echo $order['Time']; ?></td>
                                    <td><?php echo $order['Team']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if ($page <= 1) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($page <= 1) {
                                                                echo '#';
                                                            } else {
                                                                echo "?page=" . $prev;
                                                            } ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $totoalPages; $i++) : ?>
                                <li class="page-item <?php if ($page == $i) {
                                                            echo 'active';
                                                        } ?>">
                                    <a class="page-link" href="admin_page.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?php if ($page >= $totoalPages) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($page >= $totoalPages) {
                                                                echo '#';
                                                            } else {
                                                                echo "?page=" . $next;
                                                            } ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div id="sectionC" class="tab-pane fade">
            <div class="container mt-5">
                    <h2 class="text-start mb-5">Settings</h2>
                        <div>
                            <h4 class="text-start mb-5">No settings found!</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery + Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#records-limit').change(function() {
                $('form').submit();
            })
        });
    </script>
    <script>
        //line
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                        label: "Response Latancy",
                        data: [65, 59, 80, 81, 56, 55, 40],
                        backgroundColor: [
                            'rgba(105, 0, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(200, 99, 132, .7)',
                        ],
                        borderWidth: 2
                    },
                    {
                        label: "SEO Response",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        backgroundColor: [
                            'rgba(0, 137, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(0, 10, 130, .7)',
                        ],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true
            }
        });
    </script>
    <script>
        //bar
        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: ["Klassy Catering", "Gala Catering", "204 VIP"],
                datasets: [{
                    label: 'Orders Received',
                    data: [12, 19, 6],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',

                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
</body>

</html>