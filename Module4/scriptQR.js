const qr = document.querySelector(".qr"),
qrInput = qr.querySelector(".qr input"),
generateBtn = qr.querySelector(".qr button"),
qrImg = qr.querySelector(".qrCode img");


generateBtn.addEventListener("click", () =>{
    let qrValue = qrInput.value;
    if(!qrValue) return; // if the input empty then return form here
    generateBtn.innerText = "Generating QR Membership...";
    // getting Qr code of user entered value using the qrserver
    // api and passing the api returned img src to qrImg
    qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=Example=${qrValue}`
    qrImg.addEventListener("load", () => { //once QR code img loaded
        qr.classList.add("active");
        generateBtn.innerText = "Generate QR Membership";
    }); 
});

qrInput.addEventListener("keyup" , () => {
    if(!qrInput.value){
        qr.classList.remove("active");
    }
});
