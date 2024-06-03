function getQueryVariable(variable){
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){
                   var str=decodeURIComponent(pair[1]);
                   return str;
               }
       }
       return(false);
}

function editConversations(id){
    var url="conversations.php?id="+id;
    var URLsearch=$('.searchInput').val();
    var URLfilter; URLfilter=getQueryVariable("filter");
    var URLkeyword; URLkeyword=getQueryVariable("keyword");
    if (URLfilter){url+="&filter="+URLfilter;}
    if (URLkeyword){url+="&keyword="+URLkeyword;}
    if (URLsearch!==""){url+="&search="+URLsearch;}
    window.location.href=url;
}
