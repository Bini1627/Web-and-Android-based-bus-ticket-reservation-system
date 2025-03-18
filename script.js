document.addEventListener("DOMContentLoaded", function () {
    const routeSelect = document.getElementById("route");
    const busSelect = document.getElementById("bus");
    const seatMap = document.getElementById("seatMap");
    const selectedSeatInput = document.getElementById("selectedSeat");

    // Load routes
    fetch("get_routes.php")
        .then((response) => response.json())
        .then((routes) => {
            routes.forEach((route) => {
                const option = document.createElement("option");
                option.value = route.route_id;
                option.textContent = `${route.source} to ${route.destination} Date ${route.departure_time} Price: ${route.price}`;
                routeSelect.appendChild(option);
                
            });
        });

    // Load buses based on route
    routeSelect.addEventListener("change", function () {
        busSelect.innerHTML = "<option value=''>----------------------------------------------------------------Select Bus----------------------------------------------------------------</option>";
        if (this.value) {
            fetch(`get_buses.php?route_id=${this.value}`)
                .then((response) => response.json())
                .then((buses) => {
                    buses.forEach((bus) => {
                        const option = document.createElement("option");
                        option.value = bus.bus_id;
                        option.textContent = `Bus ${bus.bus_number}`;
                        busSelect.appendChild(option);
                    });
                });
        }
    });

// Load seats based on bus
busSelect.addEventListener("change", function () {
    seatMap.innerHTML = ""; // Clear the seat map
    if (this.value) {
        // Fetch seat data and bus capacity from the server
        fetch(`get_seats.php?bus_id=${this.value}`)
            .then((response) => response.json())
            .then((data) => {
                const { capacity, reservedSeats } = data;

                for (let i = 1; i <= capacity; i++) { // Use bus capacity dynamically
                    const seat = document.createElement("div");
                    seat.className = "seat " + (reservedSeats.includes(i) ? "reserved" : "available");
                    seat.textContent = i;

                    if (!reservedSeats.includes(i)) {
                        seat.addEventListener("click", function () {
                            // Deselect previously selected seat
                            document.querySelectorAll(".seat.selected").forEach((el) => el.classList.remove("selected"));

                            // Select the clicked seat
                            seat.classList.add("selected");

                            // Update the hidden input for the selected seat
                            selectedSeatInput.value = i;
                        });
                    } else {
                        seat.classList.add("disabled");
                    }

                    seatMap.appendChild(seat);
                }
            });
    }
});
});
document.addEventListener("DOMContentLoaded", () => {
    // Select modal elements
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");

    // Select buttons for opening modals
    const loginButton = document.getElementById("loginButton");
    const registerButton = document.getElementById("registerButton");

    // Select close buttons for modals
    const closeLogin = document.getElementById("closeLogin");
    const closeRegister = document.getElementById("closeRegister");

    // Function to open a modal
    function openModal(modal) {
        modal.style.display = "flex";
    }

    // Function to close a modal
    function closeModal(modal) {
        modal.style.display = "none";
    }

    // Event listeners for opening modals
    loginButton.addEventListener("click", () => openModal(loginModal));
    registerButton.addEventListener("click", () => openModal(registerModal));

    // Event listeners for closing modals
    closeLogin.addEventListener("click", () => closeModal(loginModal));
    closeRegister.addEventListener("click", () => closeModal(registerModal));

    // Close the modal if the user clicks outside the modal content
    window.addEventListener("click", (event) => {
        if (event.target === loginModal) closeModal(loginModal);
        if (event.target === registerModal) closeModal(registerModal);
    });
});

