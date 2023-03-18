function calculateTotal() {
  	// Get all the cart item elements
  	var cartItems = document.getElementsByClassName("item-block-long");
  	// Loop through each cart item element
  	var total = 0;
  	for (var i = 0; i < cartItems.length; i++) {
	    var cartItem = cartItems[i];
	    // Get the item amount and price
	    var itemAmount = cartItem.querySelector("input").value;
	    var itemPrice = cartItem.querySelector(".item-price").textContent.replace("$ ", "");
	    var itemSubtotal = itemAmount * itemPrice;
	    cartItem.querySelector(".item-subtotal").textContent = "Subtotal $ " + itemSubtotal.toFixed(2);
	    
	    total += itemSubtotal;
	}
  	// Update the total
	document.getElementById("total").textContent = total.toFixed(2);
}

// Add an event listener to each item amount input
var itemAmountInputs = document.querySelectorAll(".item-block-long input");
for (var i = 0; i < itemAmountInputs.length; i++) {
	itemAmountInputs[i].min = 0;
	itemAmountInputs[i].addEventListener("change", calculateTotal);
}

window.onload = function() {
	calculateTotal();
};



