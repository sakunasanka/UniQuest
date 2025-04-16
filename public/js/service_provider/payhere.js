function paymentGateway(plan = 'professional', userId = null) {
    // Set plan details

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
            
            // Payment completed callback
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                
                // Send confirmation to server
                var saveData = new XMLHttpRequest();
                saveData.open("POST", "http://localhost/UniQuest/service_provider/process_payment_ajax", true);
                saveData.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                saveData.send("order_id=" + orderId + "&plan=" + plan + "&user_id=" + userId);
                saveData.onreadystatechange = function() {
                    if (saveData.readyState == 4) {
                        if (saveData.status == 200) {
                            var response = JSON.parse(saveData.responseText);
                            if (response.status === 'success') {
                                if (typeof localStorage !== 'undefined') {
                                    localStorage.setItem('show_payment_success', 'true');
                                }
                                window.location.reload();
                            } else {
                                console.log("Plan:", plan);
                                console.log("User ID:", userId);
                                Flash.show('Payment processed but database update failed. Please contact support.', 'error');
                            }
                        } else {
                            Flash.show('Payment was processed but there was an issue updating your account. Please contact support.', 'error');
                        }
                    }
                };
                
                
                
            };
            
            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                console.log("Payment dismissed");
                Flash.show('Payment canceled. You can try again later.', 'error');
            };
            
            // Error occurred
            payhere.onError = function onError(error) {
                console.log("Error:" + error);
                Flash.show('An error occurred during payment. Please try again.', 'error');
            };
            
            // Payment configuration
            var payment = {
                "sandbox": true,
                "merchant_id": "1230028",
                "return_url": "http://localhost/UniQuest/service_provider/payment_return?order_id=" + obj.order_id + "&user_id=" + userId,
                "cancel_url": "http://localhost/UniQuest/pages/serviceprovider/premiumFeatures",
                "notify_url": "http://localhost/UniQuest/service_provider/premium_pro?user_id=" + userId,
                "order_id": obj.order_id,
                "items": planName,
                "amount": obj.amount,
                "currency": obj.currency,
                "hash": obj.hash,
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
                "custom_1": plan,
                "custom_2": userId.toString() // Store user ID in custom field
            };
            
            payhere.startPayment(payment);
        }
    }
    
    xhttp.open("GET", "http://localhost/UniQuest/service_provider/payhereprocess?plan=" + plan + "&user_id=" + userId, true);
    xhttp.send();
}

function initiatePayment(plan, amount, userId) {
    paymentGateway(plan, userId);
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof localStorage !== 'undefined' && localStorage.getItem('show_payment_success') === 'true') {
        Flash.show('Payment successful! Your subscription has been activated.', 'success');
        localStorage.removeItem('show_payment_success');
    }
});