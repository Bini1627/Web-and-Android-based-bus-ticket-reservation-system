<?php
include 'db.php';
if (isset($_POST['comments']))  {
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Insert new passenger
    $query = "INSERT INTO comments (`passenger_email`, `comment`) VALUES ('$name','$comment')";
    if ($conn->query($query)) {
       
        echo "<script>alert('success')</script>";
       
    } else {
        echo "Registration failed: " . $conn->error;
    }

}
include 'header&footer/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Reservation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="welcome">
        <div class="content">
            <h1>WSBS Bus Ticket Booking System</h1>
            <p>Now finding bus tickets is easier, you can order online at WSBS. No need to bother going to<br> the terminal or agent office, now you can buy tickets easily. Fast and Easy Booking. Free to<br> Choose Seats. Cheapest Every Day. 24/7 Customer Service. All Classes and Routes.</p>
            <div class="book"><a href="" >BOOK NOW</a></div>
         </div>
        
    </div>
    <div class="step">
          <h1>STEPS TO BOOK A BUS TICKET</h1>
            <div class="description">
            <div class="discription1">
            <img src="img/b1.png" alt="">
                <h3>Select trip details</h3>
             </div>
            <div class="discription1">
            <img src="img/b2.png" alt="">
                <h3>Choose your bus and seat</h3>
            </div>
            <div class="discription1">
            <img src="img/b3.png" alt="">
                <h3>Easy Payment Method</h3>          
            </div>
        </div>
        <div class="about">
            <h1 id="a">ABOUT US</h1>
            <div class="aboutdisc">
                    <div class="about1">
                        <i class="fa fa-newspaper-o"></i>
                        <h3>Get Bus Tickets from the <br>comfort of your home</h3>
                        <p>Book Bus tickets from anywhere using the robust ticketing platform exclusively built to provide the <br>passengers with pleasant ticketing experience.</p>            
                    </div>
                    <div class="about1">
                        <i class="fa fa-diamond"></i>
                        <h3>Bus & Ticketing related information<br> at your fingertips</h3>
                        <p>Checkout available seats, route information, fare information on real time basis.</p>            
                    </div>
                    <div class="about1">
                        <i class="fa fa-dollar"></i>
                        <h3>Pay Securely</h3>
                        <p>Online payment.</p>            
                    </div>
            </div>

            <div class="contact">
                <h2 id="c">Contact Us</h2>
                <h4><i class="fa fa-phone"></i>&nbsp&nbsp +2519-61-99-73-91</h4>
                <h4><i class="fa fa-envelope-o"></i>&nbsp&nbsp wsbs@gmail.com</h4>
                <h4><i class="fa fa-paper-plane"></i>&nbsp&nbsp https//:tme.wsbs.org</h4>
            </div>
            <div class="contact1">
                <h2>Comment</h2>
                <p>You can trust us. we only send offers, not a single spam.</p>
                    <form action="index.php" method="POST">
                    <div class="input">
                    <input type="email" name="name" placeholder="Email"  required>
                    </div><br>
                    <div class="input">
                    <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Write your comment here..." required></textarea><br>
                    
                    </div>
                    <input type="submit" value="send" name="comments">
                    </form>
              </div>
                
            </div>
        </div>
        <?php include 'header&footer/footer.php';?>
       
</body>
</html>
