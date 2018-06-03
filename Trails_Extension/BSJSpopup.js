/*
function Get_History() {
chrome.history.search({text:'',maxResults:2}, function(data) {
   data.forEach(function(page) {
        document.write(page.id+
        	"\n"+page.title+
        	"\n"+page.url+
        	"\n"+page.lastVisitTime+
        	"\n"+page.visitCount+
        	"\n"+page.typeCount);
    });
});
}
document.getElementById('Trails').onclick = Get_History;
*/

function Capture_Flow() {

  var flow = {};

  chrome.history.search({
    text:'',
    maxResults:100
  },
  function(historyItems) {
    console.log(historyItems);
    for(var i = 0; i < historyItems.length; ++i){
      /*flow[i] = {};
      flow[i]["id"] = historyItems[i].id;
      flow[i]["url"] = historyItems[i].url;
      flow[i]["title"] = historyItems[i].title;
      flow[i]["lastVisitTime"] = historyItems[i].lastVisitTime;
      flow[i]["typedCount"] = historyItems[i].typedCount;
      flow[i]["visitCount"] = historyItems[i].visitCount;
      */
      var url = historyItems[i].url;
      console.log(url)
      var processVisitsWithUrl = function(url) {
          // We need the url of the visited item to process the visit.
          // Use a closure to bind the  url into the callback's args.
          return function(visitItems) {
            processVisits(url, visitItems);
          };
        };
        chrome.extension.getBackgroundPage().console.log('foo');
        chrome.history.getVisits({url: url}, processVisitsWithUrl(url));
        /*
        chrome.history.getVisits({
          url: flow[i]['url']},
          function transition(visitItem)
          {
            alert(visitItem.transition);
            // var transition_flow=JSON.stringify(url);
            flow[i]["referringVisitId"] = visitItem.referringVisitId;
            flow[i]["transition"] = visitItem.transition;
          }
          );*/
        }
      });

  var processVisits = function(url, visitItems) {
    for (var i = 0, ie = visitItems.length; i < ie; ++i) {
      /*flow[i]["referringVisitId"] = visitItem.referringVisitId;
      flow[i]["transition"] = visitItem.transition;*/
      historyItems.push({})
    }
  };
  
  // Converting to json to send to server
  var json_flow=JSON.stringify(flow);
  alert(json_flow);
  // Creating a new invisible document
  d = document;
  var f = d.createElement('form');
  f.action = 'http://localhost/Trails_Server/test.php';
  f.method = 'post';
  // Attaching a form to the document
  var i = d.createElement('input');
  i.type = 'hidden';
  i.name = 'flow';
  i.value = json_flow;
  f.appendChild(i);

  d.body.appendChild(f);
  f.submit();
}

document.getElementById('Trails').onclick = Capture_Flow;

/*
     request= new XMLHttpRequest();
     request.open("POST", "http://localhost/test.php", true);
     request.setRequestHeader("Content-type", "application/json");
     request.send(json_history);
     */