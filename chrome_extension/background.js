

var parserUrl = "http://localhost/mmda/add_webpage.php";

function goToParser() {
  console.log('...');
  
  chrome.tabs.getSelected(null, function(tab) {
  chrome.tabs.create({url: parserUrl + "?url=" + tab.url});
  });
  //chrome.tabs.getSelected(null, function(tab) {
//  var url1 = tab.url;
//  });
//  var targetUrl = parserUrl + "?url=" + url1;
//  chrome.tabs.create({url: targetUrl});//{url: parserUrl + "?url=" + chrome.tabs.getCurrent().url} );
   // go to parser page and pass current tab's url as get vat
}


chrome.browserAction.onClicked.addListener(goToParser);

