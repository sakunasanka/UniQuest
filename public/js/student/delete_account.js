let dapopup = document.getElementById("popup-stu");

function showdeleteaccountconfirm() {
    popup_stu.classList.toggle("active");
}

let dapopup =document.querySelector(".container");
const pageWrapper = document.querySelector(".page-wrapper");
function showdeleteaccountconfirm(){
    dapopup.classList.add("active");
}

function closedeleteaccountconfirm(){
    dapopup.classList.remove("active");
}

function canceldeleteaccountconfirm(){
    dapopup.classList.remove("active");
}