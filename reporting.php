<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reporting</title>
      <link rel="stylesheet" href="./css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/datepicker.min.css">
      <link rel="stylesheet" href="./css/style.css">
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>

   <style>

.reporting--wrapper {
    width: 900px;
    min-width: 900px;
    margin: 0 auto;
    min-height: calc(100vh - 220px);
}
.range--wrapper > label{
  font-size: 20px;
  font-weight: 400;
}
.range--wrapper > button{
  margin-top: 33px;
}
.range--wrapper{
  padding-top: 10px;
  padding-bottom: 10px;
}
canvas{
  height: 250px;
}
</style>

<div class="main--wrapper">
  <header>
   <div class="top--line"></div>
   <div class="logo">
     <img src="./img/logo.webp"/>
   </div>
  </header>
  <main class="reporting--wrapper">
<div class="row">
  <form>
   <div class="col-md-5 range--wrapper">
   <label>M1:</label>
   <div class="input-group input-daterange">
    <input type="text" class="form-control datepicker" name="m1_from" placeholder="From" required>
    <div class="input-group-addon">to</div>
    <input type="text" class="form-control datepicker"  name="m1_to" placeholder="To" required>
</div>
   </div>

   <div class="col-md-5 range--wrapper">
   <label>M2:</label>
   <div class="input-group input-daterange">
    <input type="text" class="form-control datepicker" name="m2_from" placeholder="From" required>
    <div class="input-group-addon">to</div>
    <input type="text" class="form-control datepicker" name="m2_to" placeholder="To" required>
</div>
   </div>

   <div class="col-md-2 range--wrapper">
     <input type="hidden" name="reporting" value="<?php echo time(); ?>"/>
   <button class="btn btn-success" type="submit">Filter</button>
   </div>
</form>


<div class="col-md-12">
<canvas id="myChart" width="400" height="400"></canvas>
</div>
</div>

<div class="row">
  <div class="col-md-6 m1--wrapper" style="display:none">
  <h3></h3>
  <table  class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Total Feedback</th>
                            <th>No of Send Messages</th>
                            <th>Response Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
    </div>

  <div class="col-md-6 m2--wrapper" style="display:none">
 <h3></h3>
  <table  class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Total Feedback</th>
                            <th>No of Send Messages</th>
                            <th>Response Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
    </div>
</div>

</main>
  <footer>

  </footer>
</div>

      <script src="./js/jquery-1.12.4.min.js"></script>
      <script src="./js/bootstrap.min.js"></script>
      <script src="./js/chart.min.js"></script>
      <script src="./js/datepicker.min.js"></script>
      <script>










  $(".datepicker").datepicker({
     format: "yyyy-mm-dd",
     autoclose: true,
}).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});






  $(document).on('submit', '.reporting--wrapper form', function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();



        $.ajax({
            method: 'POST',
            url: "./ajax.php",
            dataType: 'json',
            data: data,
            beforeSend: function(xhr) {
             // $("button").prop("disabled",true);
            },
            success: function(result) {
              if(result[0]){
              //result = JSON.parse(result);
              var ctx = document.getElementById("myChart").getContext("2d");

            
              let chart_status = Chart.getChart("myChart"); // <canvas> id
if (chart_status != undefined) {
  chart_status.destroy();
}


var myBarChart = new Chart(ctx, {
  type: 'bar',
  data:   result[0],
  options: {
    responsive: true,
    maintainAspectRatio: false
  }
});
              }

if(result[1]){
  var m1 = result[1].M1;
  var m2 = result[1].M2;
  var m1Tbody =  $(".m1--wrapper table tbody");
  var m2Tbody =  $(".m2--wrapper table tbody");
  $("table tbody tr").remove();
  $(".m1--wrapper > h3").text("M1: "+result[2]);
  $(".m2--wrapper > h3").text("M2: "+result[3]);
  Object.keys(m1).map(function(k){ 
    m1Tbody.append("<tr><td>"+k+"</td><td>"+m1[k].total+"</td><td>"+m1[k].no_of_message_send+"</td><td>"+((m1[k].total/m1[k].no_of_message_send)*100).toFixed(2)+"%</td></tr>");    
  });
  Object.keys(m2).map(function(k){ 
    m2Tbody.append("<tr><td>"+k+"</td><td>"+m2[k].total+"</td><td>"+m2[k].no_of_message_send+"</td><td>"+((m2[k].total/m2[k].no_of_message_send)*100).toFixed(2)+"%</td></tr>");    
  });
  $(".m1--wrapper,.m2--wrapper").removeAttr("style");
    
}


            },
        });
    });




      </script>
   </body>
</html>