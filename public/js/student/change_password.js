

let cpwpopup =document.getElementById("changep_password-form-container");
let prow1Content = document.querySelector(".page-wrapper"); 
function showChangePasswordForm(){
    
    cpwpopup.classList.add("active");
    prow1Content.classList.add("blur");
    

}

function closeChangePasswordForm(){
    cpwpopup.classList.remove("cpwpop");
    prow1Content.classList.remove("blur");

}