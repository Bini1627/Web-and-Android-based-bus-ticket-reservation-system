<?php
 session_start();
if (isset($_SESSION['user_id'])) {
}else{
    header("Location: unauthorized.php");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Reservation Page</title>
                <link rel="stylesheet" href="styles.css">
                <script src="script.js" defer></script>
                <style> 
                    /* General Reset */
            body, h2, p, form, label, select, button {
                margin: 0;
                padding: 0;

            }

            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                color: #333;
                line-height: 1.6;
                padding: 20px;
            }

            /* Header and Footer */
            header, footer {
                background-color: #333;
                color: #fff;
                text-align: center;
                padding: 15px 0;
            }

            header a, footer a {
                color: #f4f4f9;
                text-decoration: none;
            }

            main {
                max-width: 800px;
                margin: 20px auto;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            /* Form Styles */
            form {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            label {
                font-weight: bold;
                margin-bottom: 5px;
            }

            select {
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f9f9f9;
                outline: none;
                transition: border 0.3s ease;
            }

            select:focus {
                border-color: #007bff;
            }

            #seatMap {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
                gap: 10px;
                margin-top: 10px;
                padding: 10px;
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
            }

            .seat {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 50px;
                height: 50px;
                font-size: 14px;
                font-weight: bold;
                color: #fff;
                background-color: #4caf50; /* Green for available */
                border-radius: 5px;
                cursor: pointer;
                transition: transform 0.2s ease, background-color 0.3s ease;
            }

            .seat:hover {
                transform: scale(1.1);
            }

            .seat.reserved {
                background-color: #d9534f; /* Red for reserved */
                cursor: not-allowed;
            }

            .seat.disabled {
                background-color: #6c757d; /* Gray for disabled */
                cursor: not-allowed;
            }

            .seat.selected {
                background-color: #007bff; /* Blue for selected */
            }

            /* Button Styles */
            #rbtn {
                padding: 10px 15px;
                font-size: 16px;
                color: #fff;
                background-color: #007bff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            #rbtn:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }

            /* Responsive Design */
            @media (max-width: 600px) {
                main {
                    padding: 10px;
                }

                #seatMap {
                    grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
                }

                .seat {
                    width: 40px;
                    height: 40px;
                    font-size: 12px;
                }

                button {
                    font-size: 14px;
                    padding: 8px 10px;
                }
            }

                </style>
</head>
<body>
    <?php include 'header&footer/headerreservation.php';
                
            // Define the table and column
            $table = 'schedules'; // Replace with your table name
            $column = 'departure_time'; // Replace with your TIMESTAMP column name


            // Get current time
            $currentTime = date('Y-m-d H:i:s');
            // Query to fetch expired reservations (departure_time minus 1 hour is earlier than the current time)
            $query = "SELECT schedule_id, $column FROM $table WHERE DATE_SUB($column, INTERVAL 10 minute) < ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $currentTime);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $expiredReservations = [];

                // Fetch all expired reservations
                while ($row = $result->fetch_assoc()) {
                    $expiredReservations[] = $row;
                }
                $conn->query("SET FOREIGN_KEY_CHECKS = 0");
                // Loop through and delete each expired reservation
                foreach ($expiredReservations as $reservation) {
                
                    $deleteQuery = "DELETE FROM schedules WHERE schedule_id = ?";
                    $deleteStmt = $conn->prepare($deleteQuery);
                    $deleteStmt->bind_param("i", $reservation['schedule_id']); // Assuming 'reservation_id' is the primary key

                    if ($deleteStmt->execute()) {
                    } else {
                        echo "Failed to cancel reservation with ID " . $reservation['schedule_id'] . ": " . $deleteStmt->error . "<br>";
                    }

                    $deleteStmt->close();
                }
                $conn->query("SET FOREIGN_KEY_CHECKS =1 ");

            } else {
                echo "Error fetching expired reservations: " . $stmt->error;
            }



    ?>
    <br><br><br><br>
    <main>
   
        <h2>Make a Reservation</h2>
        <form id="reservationForm" action="process_reservation.php" method="POST">
            <label for="route">Select Route:</label>
            
            <select id="route" name="route" required>
                <option value="">----------------------------------------------------------------Select Route----------------------------------------------------------------</option>
            </select>

            <label for="bus">Select Bus:</label>
            <select id="bus" name="bus" required>
                <option value="">----------------------------------------------------------------Select Bus----------------------------------------------------------------</option>
            </select>
           
            <label for="seat">Choose Your Seat:</label>
            <div id="seatMap"></div>
            <input type="hidden" id="selectedSeat" name="seat">
            <input type="hidden" id="passengerId" name="passengerId" value="<?php echo $_SESSION['user_id']; ?>">

            <button id="rbtn" type="submit">Reserve</button>
        </form>
        
    </main>
    <?php include 'header&footer/footer.php';?>
</body>
</html>
