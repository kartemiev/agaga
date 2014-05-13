$(function(){
  	$.each($('.select2'),function(index,value){
		console.log(value);
$(value).select2({
    placeholder: $(value).attr("placeholder"),
    minimumInputLength: 0,
    ajax: {  
        url: $(value).data('url'),
        dataType: 'jsonp',
        data: function (term, page) {
            return {
                q: term, // search term
                page: page, // page number
                field: $(value).attr("name"),
                page_limit: 50
             };
        },
        results: function (data, page) { // parse the results into the format expected by Select2
        	 var more = (page * 50) < data.total; 
             return {results: data.results,more:more};
        }
    },
 
    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
    escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
});


if (1===$(value).length){
$.ajax($(value).data('url'),{data:{},dataType:"jsonp",
	success: function(data){
 		$(value).select2("data",{id: data.results[0].id, text: '<b>'+data.results[0].text+'<b>'});		
	}
}
);
 		};
});
 		});


$(function(){
  	$.each($('.select2_new'),function(index,value){
		console.log(value);
$(value).select2({
 
     minimumInputLength: 0,
initSelection : function (element, callback) {
    var data = {id: element.val(), text: element.val()};
    callback(data);
},
     ajax: {  
        url: $(value).data('url'),
        dataType: 'jsonp',
        data: function (term, page) {
            return {
                q: term, // search term
                page: page, // page number
                field: $(value).attr("name"),
                page_limit: 50
             };
        },
        results: function (data, page) { // parse the results into the format expected by Select2
        	 var more = (page * 50) < data.total; 
             return {results: data.results,more:more};
        }
    },
 
    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
    escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
});

 
 
});
 		});
	
	