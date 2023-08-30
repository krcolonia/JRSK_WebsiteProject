function additionalFee() {
    let addFeeInput = document.getElementById('addService').value;

    var addFeeCont = document.getElementById('addFeeCont');

    if(addFeeInput != "") {
        addFeeCont.style.display="block";
        addFeeCont.className="active";
    }
    else {
        addFeeCont.style.display="none";
        addFeeCont.className="closed";
    }
}