function paymentGateway(plan = 'professional') {
    // Set the amount based on the selected plan
    let planAmount = 3000; // Default to Professional plan
    let planName = "Professional For growing businesses";
    
    if (plan === 'enterprise') {
        planAmount = 5000;
        planName = "Enterprise For large businesses";
    }
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var obj = JSON.parse(xhttp.responseText);
            
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                // Redirect to a success page or refresh the current page
                alert("Payment successful! Your subscription has been activated.");
                window.location.reload();
            };
            
            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                console.log("Payment dismissed");
                alert("Payment canceled. You can try again later.");
            };
            
            // Error occurred
            payhere.onError = function onError(error) {
                console.log("Error:" + error);
                alert("An error occurred during payment. Please try again.");
            };
            
            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "1230028",    // Replace your Merchant ID
                "return_url": undefined,     // Important
                "cancel_url": undefined,     // Important
                "notify_url": "http://localhost/UniQuest/service_provider/premium_pro",
                "order_id": obj["order_id"], 
                "items": planName,
                "amount": obj["amount"], 
                "currency": obj["currency"], 
                "hash": obj["hash"], 
                "first_name": "Saman",
                "last_name": "Perera",
                "email": "samanp@gmail.com",
                "phone": "0771234567",
                "address": "No.1, Galle Road",
                "city": "Colombo",
                "country": "Sri Lanka",
                "delivery_address": "No. 46, Galle road, Kalutara South",
                "delivery_city": "Kalutara",
                "delivery_country": "Sri Lanka",
                "custom_1": plan, // Store the plan type for reference
                "custom_2": ""
            };
            
            payhere.startPayment(payment);
        }
    }
    
    // Pass the plan type to the backend
    xhttp.open("GET", "http://localhost/UniQuest/service_provider/payhereprocess?plan=" + plan, true);
    xhttp.send();
}

// Function to initiate enterprise payment
function initiatePayment(plan, amount) {
    paymentGateway(plan);
}