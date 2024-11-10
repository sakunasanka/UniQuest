
let dapopup =document.querySelector(".l-container");
const pageWrapper = document.querySelector(".page-wrapper");
function showdeleteaccountconfirm(){
    
    
    dapopup.classList.add("active");
    pageWrapper.classList.add("blur");
    

}

function closedeleteaccountconfirm(){
    dapopup.classList.remove("active");
    pageWrapper.classList.remove("blur");

}

function canceldeleteaccountconfirm(){
    dapopup.classList.remove("active");
    pageWrapper.classList.remove("blur");
}