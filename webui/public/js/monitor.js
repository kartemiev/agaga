function updateTimeStamp()
{         
    $('.incall').pulse({opacity: 0.8}, {duration : 100, pulses : 5});
}
$(
    function(){
    $("#updatednotification").show();
    updateTimeStamp();
setInterval(function() {
    $('#monitoringview').load(window.location + ' #monitoringview',function(){
      updateTimeStamp();
    }); 
}, 2000);
    }    
    );