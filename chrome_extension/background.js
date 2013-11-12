

var parserUrl = "https://[OUR DOMAIN].com/siteparser.php";

function goToParser() {
  console.log('...');
   // go to parser page and pass current tab's url as get vat
}


chrome.browserAction.onClicked.addListener(goToParser);

