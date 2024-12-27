// Function to add car to the reservation cart
function addToCart(carId, carModel, carPrice) {
    const cart = JSON.parse(localStorage.getItem('reservationCart')) || [];
    
    // Check if the car is already in the cart
    const existingCar = cart.find(item => item.carId === carId);
    
    if (existingCar) {
      // If the car is already in the cart, just increase the quantity
      existingCar.quantity++;
    } else {
      // If the car is not in the cart, add a new entry
      cart.push({ carId, carModel, carPrice, quantity: 1 });
    }
    
    // Save the updated cart back to localStorage
    localStorage.setItem('reservationCart', JSON.stringify(cart));
  
    alert(`${carModel} added to your cart!`);
  }
  
  // Function to view the cart
  function viewCart() {
    window.location.href = '../HTML/MyCart.html'; // Redirect to the cart page
  }
  