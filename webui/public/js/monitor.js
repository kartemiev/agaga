function updateTimeStamp()
{         
    $('.incall').pulse({opacity: 0.8}, {duration : 100, pulses : 5});
}
$(
    function(){
    $("#updatednotification").show();
    updateTimeStamp();
setInterval(function() {
	var url = window.location + ' #monitoringview';
     $('#monitoringview').load(url,function(){
      updateTimeStamp();
    }); 
}, 2000);
    }    
    );