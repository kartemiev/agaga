     $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });
            $('.slider').slider();
            // $('.selectpicker').selectpicker('hide');
        });

jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
} 

function ajaxasizeLinksGlobally(){
    $('a').click(function(event)
 {
      event.preventDefault();
       $('#thisbody').load(event.currentTarget.href + ' #thisbody',ajaxasizeLinksGlobally);

 }
  
);}
/*
window.onbeforeunload = function() {
    return "Вы уверены что вы хотите покинуть страницу?";
};*/
/*
$(function(){
 	ajaxasizeLinksGlobally();
	$('.dropdown-toggle').dropdownHover();
	
});
*/
 
$(
function()
{
	$(".auto_submit_item").change(function() {
		document.forms["offdayrangefilter"].submit();
	});
	$("form#offdayrangefilter input#submitbutton").hide();
	$(".deletelink").click(function()
	{
		var r=confirm("Вы действительно хотите удалить пользователя")
		if (r!==true)
		  {
			event.preventDefault();
		  }
		}	
	);
$('.hiddennojs').show();	 
$('#detailsshow').click(
function(){
	$("#detailsshow").delay(10000).hide();
	$("#sipidname").text($("#name").val());
	$("#sipidpass" ).text($("#secret").val());
 	}		
);
}
);

$(function(){
$(".selectspecial#confnumber").select2({
    placeholder: "ожидайте загрузки",
    minimumInputLength: 0,
    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url: "/createconference/fetch",
        dataType: 'jsonp',
        data: function (term, page) {

            return {
                q: term, // search term
                page_limit: 10
             };
        },
        results: function (data, page) { // parse the results into the format expected by Select2
             // since we are using custom formatting functions we do not need to alter remote JSON data
             return {results: data.results};
        }
    },
    initSelection: function(element, callback) {
        // the input tag has a value attribute preloaded that points to a preselected movie's id
        // this function resolves that id attribute to an object that select2 can render
        // using its formatResult renderer - that way the movie name is shown preselected
        
            $.ajax("/createconference/fetch", {
                data: {
                     q: 12
                },
                dataType: "jsonp"
            }).done(function(data) { callback(data); });
        
    },
//    formatResult: function(){alert('hello');}, // omitted for brevity, see the source of this page
//    formatSelection: function(){}, // omitted for brevity, see the source of this page
    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
    escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
});

 //$(".selectspecial#confnumber").select2("data",{id: "5976", text: "5976"});
if (1===$(".selectspecial#confnumber").length){
$.ajax('/createconference/fetch',{data:{},dataType:"jsonp",
	success: function(data){
 		$(".selectspecial#confnumber").select2("data",{id: data.results[0].id, text: '<b>'+data.results[0].text+'<b>'});		
	}
}
);

 		};
//$(".selectspecial#confnumber").select2("open");
});
$("#cdrsearch").add('<input id="cdrsearchdate" />');
$(function(){
	$("#cdrsearch").select2({
	    placeholder: "поиск по дате",
	    minimumInputLength: 0,
	    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
	        url: "/cabinet/cdr/search",
	        dataType: 'jsonp',
	        data: function (term, page) {
	    	$('#cdrview').load("/cabinet/cdr/like_by/calldate/"+encodeURIComponent(term)+' #cdrview',onAjaxload);
	            return {
	                q: term, // search term
	                page_limit: 10,
	                page: page // page number	                
	             };
	        },
	        results: function (data, page) { // parse the results into the format expected by Select2
	        var more = (page * 10) < data.total; // whether or not there are more results available
	        
	        // notice we return the value of more so Select2 knows if more results can be loaded
	        return {results: data.results, more: more};
	        }	        
	    },
	    initSelection: function(element, callback) {
	        // the input tag has a value attribute preloaded that points to a preselected movie's id
	        // this function resolves that id attribute to an object that select2 can render
	        // using its formatResult renderer - that way the movie name is shown preselected
	        
	            $.ajax("/cabinet/cdr/search", {
	                data: {
	            
 	                },
	                dataType: "jsonp"
	            }).done(function(data) { callback(data); });
	    },
//	    formatResult: function(){alert('hello');}, // omitted for brevity, see the source of this page
//	    formatSelection: function(){}, // omitted for brevity, see the source of this page
	    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
	    escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
	});

	 //$(".selectspecial#confnumber").select2("data",{id: "5976", text: "5976"});
 $("#cdrsearch").eq(0).ready(function(){
	$.ajax('/cabinet/cdr',{data:{},dataType:"jsonp",
		success: function(data){
	 		$(".selectspecial#confnumber").select2("data",{id: data.results[0].id, text: '<b>'+data.results[0].text+'<b>'});
			
		}
	}

	);
	 		}
	);
 $("#cdrsearch").on('change',function (event){
 	 $('#cdrview').load("/cabinet/cdr/like_by/calldate/"+encodeURIComponent(event.val)+' #cdrview',onAjaxload);	 
  });
 
	//$(".selectspecial#confnumber").select2("open");
	});
function deleteFieldSetElement(element)
{
	attrname = $(element).attr('name');
	var matches = attrname.match(/numbers\[(\d)\]\[deletebutton\]/);
	selects = $('input:regex(name,numbers\\['+matches[1]+'\\]\\[\\w+\\])');
	selects.next('div').remove();
	selects.remove();
	console.log($('#numbersfieldset'));
}

    function add_category() {     
        var currentCount = $('.numbersetmarkup').length;
        var template = $('#numbersfieldset>span').data('template');
         template = template.replace(/\[numbers\]/g, '['+currentCount+']');
       var templateElement = $('#newnumbersfieldset').append(template);
		$(templateElement.find('.deletebutton').click(
				function(){
					deleteFieldSetElement(this);
									}
				));
           templateElement.find('.slider').slider(
                  );
        
        return false;
    }
function add_trunk() {     
	var currentCount = $('.trunksetmarkup').length;
	console.log(currentCount);
	var template = $('#trunksfieldset>span').data('template');
	template = template.replace(/\[markupplaceholder\]/g, '['+currentCount+']');
	var templateElement = $('#newtrunkfieldset').append(template);
  	$(templateElement.find('.deletebutton').click(
		function(){
			deleteFieldSetElement(this);
				  }
		));   
 	return false;
}
function add_regentry() {     
var currentCount = $('.regentrysetmarkup').length;
console.log(currentCount);
var template = $('#regentriesfieldset>span').data('template');
template = template.replace(/\[markupplaceholder\]/g, '['+currentCount+']');
var templateElement = $('#newregentriesfieldset').append(template);
	$(templateElement.find('.deletebutton').click(
	function(){
		deleteFieldSetElement(this);
			  }
	));   
	return false;
}

function add_destination() {     
var currentCount = $('.destinationsetmarkup').length;
console.log(currentCount);
var template = $('#destinationsfieldset>span').data('template');
template = template.replace(/\[markupplaceholder\]/g, '['+currentCount+']');
var templateElement = $('#newdestinationsfieldset').append(template);
	$(templateElement.find('.deletebutton').click(
	function(){
		deleteFieldSetElement(this);
			  }
	));   
	return false;
}


function showHideShuffle()
{
	$('.shufflecontainer').each(function(index,value)
		{
			$(value).find('.subfieldsetshuffle-data').each(function(i,v){
				$(v).hide();
				var myid = v.id;
				$('label[for='+myid+']').hide();
			});
 			$(value).find(".subfieldsetshuffle-data[data-value="+$(value).find(".subfieldsetshuffle-control").val()+"]").each(
 				function(i,v){
 					$(v).show();
 					var myid = v.id;
 					$('label[for='+myid+']').show();
 				}
 				)
  		}	
	);
}
$(function(){
$('.deletebutton').click(
		function(evt)
		{ 
			deleteFieldSetElement(this);
		}	
);
$('#addnewcallingrec').click(
		function(evt)
	{ 
	return add_category();
	}	

	);
$('#addnewtrunk').click(
function(evt)
	{	 
		return add_trunk();
	}	

);
$('#addnewregentry').click(
function(evt)
	{	 
		return add_regentry();
	}	

);
$('#addnewdestination').click(
function(evt)
	{	 
		return add_destination();
	}	

);

showHideShuffle();
$('.subfieldsetshuffle-control').change(
		function(){
				showHideShuffle();
 			}
		);
$('#cleartrunks').click(function(){
		console.log($('#newtrunkfieldset'));
		$('#newtrunkfieldset').empty();
		selects = $('input:regex(name,trunks\\w+)');
		console.log(selects.prev().remove());
		selects.remove();
	}	
  );
$('#cleardestinations').click(function(){
	$('#newdestinationsfieldset').empty();
	selects = $('input:regex(name,destinations\\w+)');
	selects.prev().remove();
	selects.remove();
}	
);
 
}
);
$(function(){
	$('.showhide').click(function(){	
 		 $($(this).data('href')).toggle();
	});
});
$(function(){
	$('.togglecontainer-exclusive-primary').each(function(index,value)
		{
			var elemVal = $(value).val();
			var elemExclId = $(value).data('togglecontainer-mutuallyexclusive');
			if ('0'==elemVal)
				{
					$('#'+elemExclId).closest('.mutuallyexclusivecontainer').show();
					$(value).closest('.mutuallyexclusivecontainer').hide();
				}
				else
					{
						$('#'+elemExclId).closest('.mutuallyexclusivecontainer').hide();
						$(value).closest('.mutuallyexclusivecontainer').show();
					}
			
		});
	
$('.togglecontainer-exclusive').change(function(event)
	{
		var target = event.target; 		
 		var elemExclId = $(target).data('togglecontainer-mutuallyexclusive');
 		console.log($('#'+elemExclId).parent().closest('.mutuallyexclusivecontainer').toggle());
  		$(elemExclId).closest('.mutuallyexclusivecontainer').toggle();
 
 	});

 	$('.togglecontainer-control').each(function(index,value)
	{
		var elemVal = $(value).val();
		if ('0'==elemVal) 
		{
			$(value).closest('.togglewrapper').children('.togglecontainer').hide();
		}
	});
 	$('.togglecontainer-control').change(
 			function(event)
 			{
 				value = event.target;
  				var elemVal = value.value;
 				if ('0'==elemVal) 
 				{
 					$(value).closest('.togglewrapper').children('.togglecontainer').hide();
 				}
 				else
 				{
 					$(value).closest('.togglewrapper').children('.togglecontainer').show();
 				}
 			}
 	);
}
);

 