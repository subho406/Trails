function Get_Flow() {
   
   chrome.history.search({
      'text':'',
      'maxResults' : 10},
      
      function(data) {
         var json_flow=JSON.stringify(data);
         
         alert(json_flow);
         
         d = document;
         var f = d.createElement('form');
         f.action = 'http://localhost/Trails_Server/captureFlow.php';
         f.method = 'post';
         var i = d.createElement('input');
         i.type = 'hidden';
         i.name = 'flow';
         i.value = json_flow;
         f.appendChild(i);
         d.body.appendChild(f);
         f.submit();
   });
}

document.getElementById('Trails').onclick = Get_Flow;