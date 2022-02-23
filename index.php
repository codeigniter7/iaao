<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Imtiaz Al Arabia Co.</title>
      <link rel="stylesheet" href="./css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo $_SERVER['REQUEST_URI']?>css/style.css">
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
  <main class="feedback--wrapper">

<form>
  <h3 class="rating--title">According to your experience, what is the probability that you will recommend eyewa to one of your friends or colleagues?
    <div class="rating--list">
      <div class="rating--item">
        <input class="rating--input rating--1" id="rating-1-2" type="radio" value="1" name="rating"/>
        <label class="rating--label rating--1" for="rating-1-2"><i class="em em-angry"></i></label>
        <p>Angry</p>
      </div>
      <div class="rating--item">
        <input class="rating--input rating--2" id="rating-2-2" type="radio" value="2" name="rating"/>
        <label class="rating--label rating--2" for="rating-2-2"><i class="em em-disappointed"></i></label>
        <p>Disappointed</p>
      </div>
      <div class="rating--item">
        <input class="rating--input rating--3" id="rating-3-2" type="radio" value="3" name="rating"/>
        <label class="rating--label rating--3" for="rating-3-2"><i class="em em-expressionless"></i></label>
        <p>Expressionless</p>
      </div>
      <div class="rating--item">
        <input class="rating--input rating--4" id="rating-4-2" type="radio" value="4" name="rating"/>
        <label class="rating--label rating--4" for="rating-4-2"><i class="em em-grinning"></i></label>
        <p>Grinning</p>
      </div>
      <div class="rating--item">
        <input class="rating--input rating--5" id="rating-5-2" type="radio" value="5" name="rating"/>
        <label class="rating--label rating--5" for="rating-5-2"><i class="em em-star-struck"></i></label>
        <p>Star Struck</p>
      </div>
    </div>
  </h3>
  <div class="reason--wrapper">
    <h4></h4>
    <input type="hidden" name="_feedback" value="<?php echo time(); ?>"/>
    <textarea name="reason" id="reason" rows="5" class="form-control" required></textarea>
    <button class="btn btn-success" type="submit">Submit</button>    
  </div>
</form>

</main>
  <footer>

  </footer>
</div>   

      <script src="./js/jquery-1.12.4.min.js"></script>
      <script src="./js/bootstrap.min.js"></script>
      <script>





$('.rating--input').on('click', function() {
  $('.rating--label').removeClass('active');
  $(this).siblings('.rating--label').addClass('active');

  var rating = $(this).val();
  var p = $(this).parent().find("p").text();

  if(rating <=3){
 
    $('.reason--wrapper,.reason--wrapper textarea,.reason--wrapper h4').css('display', "block");
    $('.reason--wrapper > h4').html("Please tell us a little bit about why you chose "+p+"")
  }else{
    $('.reason--wrapper textarea,.reason--wrapper h4').hide();
    $('.reason--wrapper button').show();
  }

  });


  $(document).on('submit', '.feedback--wrapper form', function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();
    
        $.ajax({
            method: 'POST',
            url: "./ajax.php",
            dataType: 'json',
            data: data,
            beforeSend: function(xhr) {
              $(".feedback--wrapper button").prop("disabled",true);
            },
            success: function(result) {
              if(result === 1){
                $('.reason--wrapper').append("<div class='alert alert-success'>Feedback submitted</div>");
              }else{
                $('.reason--wrapper').append("<div class='alert alert-danger'>Something is wrong</div>");
              }
              setTimeout(function(){
                $(".feedback--wrapper button").prop("disabled",false);
                $(".alert").remove();
                $('.rating--label').removeClass('active');
                $(".feedback--wrapper form")[0].reset();
                $('.reason--wrapper').hide();
              },2000);
            },
        });
    });

  


      </script>  
   </body>
</html>