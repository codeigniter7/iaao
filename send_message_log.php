<?php 
require_once (__DIR__.'/config.php');
$results = $mysqli->query("SELECT * FROM `store`");
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Send Message Log</title>
      <link rel="stylesheet" href="./css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/datepicker.min.css">
      <link rel="stylesheet" href="./css/dataTables.min.css">
      <link rel="stylesheet" href="./css/style.css">
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>



<div class="main--wrapper">
  <header>
   <div class="top--line"></div>
   <div class="logo">
     <img src="./img/logo.webp"/>
   </div>
  </header>
  <main class="send--message--log--wrapper">

  <div class="row">

  <div class="col-md-6" id="msg"></div>
  <div class="col-md-6" style="padding-top:20px;padding-bottom:20px;text-align:right;"><a href="#add_modal" role="button" class="btn btn-primary" data-toggle="modal">Add</a></div>

      </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="send--message" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>No of Message Send</th>
                            <th>Message Sending Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


</main>
  <footer>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add</h5>
                </div>
                <form action="" id="new--send--message">
                <div class="modal-body">
                    <div class="container-fluid">
                     
                            <input type="hidden" value="<?php echo time(); ?>" name="add_message">
                            <div class="form-group">
                                <label for="store_id" class="control-label">Store Name</label>
                                <select name="store_id" id="store_id" class="form-control" required>
                                <option value="">Select Store</option>
                                <?php 
                                  foreach($results  as $result):
                                ?>                                    
                                  <option value="<?php echo $result["id"]; ?>"><?php echo $result["name"]; ?></option>
                                  <?php endforeach;
                                   $mysqli->close();
                                  ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_of_message_send" class="control-label">No of Message Send</label>
                                <input type="number" class="form-control " id="no_of_message_send" name="no_of_message_send" required>
                            </div>
                            <div class="form-group">
                                <label for="date" class="control-label">Message Sending Date</label>
                                <input type="text" class="form-control  datepicker" id="sending_date" name="sending_date" required>
                            </div>
                     
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Modal -->
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                </div>
                <form action="" id="edit-sending-message">
                <div class="modal-body">
                    <div class="container-fluid">
                    
                            <input type="hidden" name="id">
                            <input type="hidden" name="update_message" value="<?php echo time(); ?>">
                            <div class="form-group">
                                <label for="store_id" class="control-label">Store Name</label>
                                <select name="store_id" id="store_id" class="form-control" required>
                                <option value="">Select Store</option>
                                <?php 
                                  foreach($results  as $result):
                                ?>                                    
                                  <option value="<?php echo $result["id"]; ?>"><?php echo $result["name"]; ?></option>
                                  <?php endforeach;
                                   $mysqli->close();
                                  ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_of_message_send" class="control-label">No of Message Send</label>
                                <input type="number" class="form-control " id="no_of_message_send" name="no_of_message_send" required>
                            </div>
                            <div class="form-group">
                                <label for="date" class="control-label">Message Sending Date</label>
                                <input type="text" class="form-control  datepicker" id="sending_date" name="sending_date" required>
                            </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Modal -->
    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm</h5>
                </div>
                <form action="" id="delete-sending-message">
                <div class="modal-body">
                    <div class="container-fluid">
                     
                            <input type="hidden" name="id">
                            <input type="hidden" name="delete_message" value="<?php echo time(); ?>">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->


  </footer>
</div>

      <script src="./js/jquery-1.12.4.min.js"></script>
      <script src="./js/bootstrap.min.js"></script>
      <script src="./js/datepicker.min.js"></script>
      <script src="./js/dataTables.min.js"></script>
      <script>
  $(".datepicker").datepicker({
     format: "yyyy-mm-dd",
     autoclose: true,
}).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});


    

$(document).ready(function() {

  

   var table = $('table').DataTable({
        "searching": false,
        "bLengthChange" : false,

        buttons: [{
                text: "Add New",
                action: function(e, dt, node, config) {
                    $('#add_modal').modal('show')
                }
            }],
        "ajax": {
                url: "./ajax.php",
                dataType: 'json',
                method: "GET",
                data: {
                    "listing": <?php echo time(); ?>
                }
            },
        "columns": [
                    { "data": "store_name" },
                    { "data": "no_of_message_send" },
                    { "data": "sending_date" },
                    { "data": "action" },
                ],
    });

    $(document).on('click','.edit_data',function(e) {
        e.preventDefault();
                    $.ajax({
                        method: 'post',
            url: "./ajax.php",
            dataType: 'json',
            data: {
                "id": $(this).attr('data-id'),
                "edit_message":<?php echo time(); ?>
            },
                        success: function(resp) {
                            if (!!resp.status) {
                                Object.keys(resp.data).map(k => {
                                    console.log(k);
                                    if ($('#edit_modal').find('input[name="' + k + '"]').length > 0)
                                        $('#edit_modal').find('input[name="' + k + '"]').val(resp.data[k])
                                       $('#edit_modal').find('select option[value="'+resp.data["store_id"]+'"]').prop("selected",true);
                                })
                                $('#edit_modal').modal('show')
                            } else {
                                alert("An error occured")
                            }
                        }
                    })
                })


                $(document).on('click','.delete_data',function(e) {
        e.preventDefault();

        var result = confirm("Want to delete?");
      
  if (!result)  return false;
  
  var id =  $(this).attr('data-id');


                    $.ajax({
                        url: './ajax.php',
                        data: {
                "id":id,
                "delete_message":<?php echo time(); ?>
            },
                        method: 'POST',
                        dataType: 'json',
                        success: function(resp) {
                       
                        }
                    })
                })

  

    $('#new--send--message').submit(function(e) {
            e.preventDefault()
            $('#add_modal button').attr('disabled', true)
            $('#add_modal button:first-child').text("saving ...")
            $.ajax({
                url: './ajax.php',
                data: $(this).serialize(),
                method: 'POST',
                dataType: "json",
                success: function(resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-primary alert_msg')
                            _el.text("Data successfully saved");
                            $('#new--send--message').get(0).reset()
                            $('.modal').modal('hide')
                            $('#msg').append(_el)
                            _el.show('slow')
                            table.ajax.reload();
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove()
                            }, 2500)
                        } else if (resp.status == 'success' && !!resp.msg) {
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-danger alert_msg form-group')
                            _el.text(resp.msg);
                            $('#new--send--message').append(_el)
                            _el.show('slow')
                        } else {
                            alert("An error occure")
                        }
                    } else {
                        alert("An error occure")
                    }

                    $('#add_modal button').attr('disabled', false)
                    $('#add_modal button:first-child').text("Save")
                }
            })
        })
        // Update Data
    $('#edit-sending-message').submit(function(e) {
            e.preventDefault()
            $('#edit_modal button').attr('disabled', true)
            $('#edit_modal button:first-child').text("saving ...")
            $.ajax({
                url: './ajax.php',
                data: $(this).serialize(),
                method: 'POST',
                dataType: "json",
                success: function(resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-primary alert_msg')
                            _el.text("Data successfully update");
                            $('#edit-sending-message').get(0).reset()
                            $('.modal').modal('hide')
                            $('#msg').append(_el)
                            _el.show('slow')
                            table.ajax.reload();
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove()
                            }, 2500)
                        } else if (resp.status == 'success' && !!resp.msg) {
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-danger alert_msg form-group')
                            _el.text(resp.msg);
                            $('#edit-sending-message').append(_el)
                            _el.show('slow')
                        } else {
                            alert("An error occured.")
                        }
                    } else {
                        alert("An error occured.")
                    }

                    $('#edit_modal button').attr('disabled', false)
                    $('#edit_modal button:first-child').text("Save")
                }
            })
        })

});





</script>






   </body>
</html>
