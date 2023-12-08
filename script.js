// 66 % average IM Rating by Sennheiser WSM
// these offsets are from one to the next frequency
// offset1 - offset7 can be applied reverse order to use the mirrored spacing
var offset0 = 0.100 // space from left tv channel edge
var offset1 = 0.400
var offset2 = 0.700
var offset3 = 1.425
var offset4 = 0.525
var offset5 = 1.200
var offset6 = 2.250
var offset7 = 1.300

var direction;
var f1, f2, f3, f4, f5, f6, f7, f8;

function calculateFreqs() {
  // clear complete table
  resetTable();
  // check if there is a tv channel set in the cookies
  var channel = document.getElementById("channel").value;
  if (channel != "") {
    setCookie("channel", channel, 7); // 7 days is maximum set by safari and brave
  } else {
    var channelCookie = getCookie("channel");
    if (channelCookie != null && channelCookie != "") {
      channel = channelCookie;
      document.getElementById('channel').value = channel;
    } else {
      return;
    }
  }
  // prove if direction for spacing is set in cookies or by radios
  var directionUp = document.getElementById("up").checked;
  var directionDown = document.getElementById("down").checked;
  // no radios set (reload moment) check cookie
  if (directionUp != true && directionDown != true) {
    var directionCookie = getCookie("direction");
    if (directionCookie != null && directionCookie != "") {
      direction = directionCookie;
      if (direction == "up") {
        document.getElementById('up').checked = true;
      } else if (direction == "down") {
        document.getElementById('down').checked = true;
      }
    } else {
      // no cookie, no radios set - default direction up
      direction = 'up';
      document.getElementById('up').checked = true;
      setCookie("direction", direction, 7); // 7 days is maximum set by safari and brave
    }
  // some radio is set
  } else if (directionUp == true) {
    direction = 'up';
    setCookie("direction", direction, 7); // 7 days is maximum set by safari and brave
  } else if (directionDown == true) {
    direction = 'down';
    setCookie("direction", direction, 7); // 7 days is maximum set by safari and brave
  }
  var startFrequency =  channel * 8 + 302;
  // LTE constraints shifting startFrequency
  if (channel == 54) {
    startFrequency = 736
  } else if (channel == 65) {
    startFrequency = 824
  }
  // you can mirror the spaces between all frequencies - if you have to set 16 frequencies you better chose 1 set up direction and the second set down
  if (direction == 'up') {
    f1 = startFrequency + offset0;
    f2 = startFrequency + offset0 + offset1;
    f3 = startFrequency + offset0 + offset1 + offset2;
    f4 = startFrequency + offset0 + offset1 + offset2 + offset3;
    f5 = startFrequency + offset0 + offset1 + offset2 + offset3 + offset4;
    f6 = startFrequency + offset0 + offset1 + offset2 + offset3 + offset4 + offset5;
    f7 = startFrequency + offset0 + offset1 + offset2 + offset3 + offset4 + offset5 + offset6;
    f8 = startFrequency + offset0 + offset1 + offset2 + offset3 + offset4 + offset5 + offset6 + offset7;
  } else {
    f1 = startFrequency + offset0;
    f2 = startFrequency + offset0 + offset7;
    f3 = startFrequency + offset0 + offset7 + offset6;
    f4 = startFrequency + offset0 + offset7 + offset6 + offset5;
    f5 = startFrequency + offset0 + offset7 + offset6 + offset5 + offset4;
    f6 = startFrequency + offset0 + offset7 + offset6 + offset5 + offset4 + offset3;
    f7 = startFrequency + offset0 + offset7 + offset6 + offset5 + offset4 + offset3 + offset2;
    f8 = startFrequency + offset0 + offset7 + offset6 + offset5 + offset4 + offset3 + offset2 + offset1;
  }
  // LTE constraints cut end frequencies
  if (channel == 49 || channel == 54 || channel == 56) {
    switch (channel) {
      case '49':
        // because LTE constraints only lower 4 MHz usable
        hideFrequenciesAbove('698');
        break;
      case '54':
      // because LTE constraints only upper 5 MHz usable
        hideFrequenciesAbove('742');
        break;
      case '56':
      // because LTE constraints only lower 3 MHz usable
        hideFrequenciesAbove('753');
        break;
    }
  }
  // write it with a dot and 3 fixed decimal places
  f1 = f1.toFixed(3);
  f2 = f2.toFixed(3);
  f3 = f3.toFixed(3);
  f4 = f4.toFixed(3);
  f5 = f5.toFixed(3);
  f6 = f6.toFixed(3);
  f7 = f7.toFixed(3);
  f8 = f8.toFixed(3);
  // write all 8 frequencies into the table
  document.getElementById("f1").innerText = f1 + " MHz";
  document.getElementById("f2").innerText = f2 + " MHz";
  document.getElementById("f3").innerText = f3 + " MHz";
  document.getElementById("f4").innerText = f4 + " MHz";
  document.getElementById("f5").innerText = f5 + " MHz";
  document.getElementById("f6").innerText = f6 + " MHz";
  document.getElementById("f7").innerText = f7 + " MHz";
  document.getElementById("f8").innerText = f8 + " MHz";
  // add remarks
  // Handgeräte mit Frequenzen zwischen 823 - 826 MHz dürfen nur mit reduzierter Sendeleistung von maximal 82 mW betrieben werden
  if (channel == 65) {
    document.getElementById("n1").innerHTML = "<small><sup><a href='#footnote1'>1</a></sup></small>";
    document.getElementById("n2").innerHTML = "<small><sup><a href='#footnote1'>1</a></sup></small>";
    if (direction == "up") {
      document.getElementById("n3").innerHTML = "<small><sup><a href='#footnote1'>1</a></sup></small>";
    }
  }
}

function hideFrequenciesAbove(endFrequency) {
  // console.log('End frequency: ' + endFrequency);
  for (var i = 1; i < 9; i++) {
    // console.log(window["f" + i]);
    if (window["f" + i] > endFrequency) {
      document.getElementById("rf" + i).style.display = "none";
    }
  }
}

function resetTable() {
  // show all 8 frequencies again
  var r1 = document.getElementById("rf1");
  r1.style.display = "table-row";
  var r2 = document.getElementById("rf2");
  r2.style.display = "table-row";
  var r3 = document.getElementById("rf3");
  r3.style.display = "table-row";
  var r4 = document.getElementById("rf4");
  r4.style.display = "table-row";
  var r5 = document.getElementById("rf5");
  r5.style.display = "table-row";
  var r6 = document.getElementById("rf6");
  r6.style.display = "table-row";
  var r7 = document.getElementById("rf7");
  r7.style.display = "table-row";
  var r8 = document.getElementById("rf8");
  r8.style.display = "table-row";
  // remove all footnotes
  document.getElementById("n1").innerHTML = "";
  document.getElementById("n2").innerHTML = "";
  document.getElementById("n3").innerHTML = "";
  document.getElementById("n4").innerHTML = "";
  document.getElementById("n5").innerHTML = "";
  document.getElementById("n6").innerHTML = "";
  document.getElementById("n7").innerHTML = "";
  document.getElementById("n8").innerHTML = "";
}

function enableCellPopup() {
  var cells = document.querySelectorAll("#f1, #f2, #f3, #f4, #f5, #f6, #f7, #f8");
  for (var i = 0; i < cells.length; i++) {
    cells[i].addEventListener("click", function() {
      var text = this.innerText;
      text = text.replace(" MHz","");
      if (text != "") {
        pushDialog(text);
      }
    });
  }
}

function pushDialog(text) {
  var dialogText = document.getElementById('dialogText');
  dialogText.innerText = text;
  dialog.showModal();
}

function copyTable() {
  var urlField = document.getElementById("table");
  var range = document.createRange();
  range.selectNode(urlField);
  window.getSelection().addRange(range);
  document.execCommand('copy');
  window.getSelection().removeAllRanges();
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
