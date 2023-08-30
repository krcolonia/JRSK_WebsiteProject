// Guest Dropdown Functions

function dropDownFunc() {
  document.getElementById("myDropDown").classList.toggle("show");
  event.preventDefault();
}
  
window.onclick = function(event) {
  if (!event.target.matches('.guestDropButton')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
    }
  }
}

function findTotal() {
  var arr = document.getElementsByClassName('numGuest');
  var tot=0;
  for(var i=0; i<arr.length; i++) {
    if(parseInt(arr[i].value)){
      tot += parseInt(arr[i].value);
    }
  }
  document.getElementById('guestTotal').value = tot;

  let adult = document.getElementById('numAdults').value;
  let child = document.getElementById('numChild').value;

  document.getElementById('sumAdult').value = adult;
  document.getElementById('sumChild').value = child;
}

// Summary Functions

function checkdate() {
  let cIn = document.getElementById('checkin').value;
  let cOut = document.getElementById('checkout').value;
  
  document.getElementById('sumCin').value = cIn;
  document.getElementById('sumCout').value = cOut;
}

function checkRooms() {
  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'PHP',
  });

  var price1 = document.getElementById('testSingle').textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').trim();
  var price2 = document.getElementById('testDouble').textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').trim();
  var price3 = document.getElementById('testTwin').textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').trim();
  var price4 = document.getElementById('testTriple').textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').trim();

  price1 = parseInt(price1);
  price2 = parseInt(price2);
  price3 = parseInt(price3);
  price4 = parseInt(price4);


  var roomList1 = document.getElementById('sumRoom1');
  var roomList2 = document.getElementById('sumRoom2');
  var roomList3 = document.getElementById('sumRoom3');
  var roomList4 = document.getElementById('sumRoom4');

  var roomPrice1 = document.getElementById('roomPrice1');
  var roomPrice2 = document.getElementById('roomPrice2');
  var roomPrice3 = document.getElementById('roomPrice3');
  var roomPrice4 = document.getElementById('roomPrice4');

  let room1 = document.getElementById('numSingle').value;
  let rateSingle = price1 * room1;

  if(document.getElementById('numSingle') != null) {
    
    if(room1 != 0) {
      roomList1.innerHTML = "Single Room: " + room1;
      roomPrice1.innerHTML = formatter.format(rateSingle) + " per night";
    }
    else {
      roomList1.innerHTML = "";
      roomPrice1.innerHTML = "";
    }
  }

  let room2 = document.getElementById('numDouble').value;
  let rateDouble = price2 * room2;

  if(document.getElementById('numDouble') != null) {
    
    if(room2 != 0) {
      roomList2.innerHTML = "Double Room: " + room2;  
      roomPrice2.innerHTML = formatter.format(rateDouble) + " per night";
    }
    else {
      roomList2.innerHTML = "";
      roomPrice2.innerHTML = "";
    }
  }

  let room3 = document.getElementById('numTwin').value;
  let rateTwin = price3 * room3;

  if(document.getElementById('numTwin') != null) {

    if(room3 != 0) {
      roomList3.innerHTML = "Twin Room: " + room3;
      roomPrice3.innerHTML = formatter.format(rateTwin) + " per night";
    }
    else {
      roomList3.innerHTML = "";
      roomPrice3.innerHTML = "";
    }
  }
  
  let room4 = document.getElementById('numTriple').value;
  let rateTriple = price4 * room4;

  if(document.getElementById('numTriple') != null) {

    if(room4 != 0) {
      roomList4.innerHTML = "Triple Room: " + room4;
      roomPrice4.innerHTML = formatter.format(rateTriple) + " per night";
    }
    else {
      roomList4.innerHTML = "";
      roomPrice4.innerHTML = "";
    }
  }
}

function numDays() {
  let checkoutDate = document.getElementById('checkout').value;
  let checkinDate = document.getElementById('checkin').value; 

  const diffInMs   = new Date(checkoutDate) - new Date(checkinDate)
  diffInDays = diffInMs / (1000 * 60 * 60 * 24);

  if(!isNaN(diffInDays) && diffInDays > 0) {
    document.getElementById('sumNights').value = diffInDays;
  }
  else {
    document.getElementById('sumNights').value = "";
  }
}

function checkDateFuncs() {
  checkdate();
  numDays();
}