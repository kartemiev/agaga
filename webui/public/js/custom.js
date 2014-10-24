$.fn.exists = function () {
    return this.length !== 0;
};  

$(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });
      //      $('.slider').slider(); ??
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
};

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
	if($('.selectspecial#confnumber').exists()){
$(".selectspecial#confnumber").select2({
    placeholder: "ожидайте загрузки",
    minimumInputLength: 0,
    ajax: {  
        url: "/createconference/fetch",
        dataType: 'jsonp',
        data: function (term, page) {

            return {
                q: term, 
                page_limit: 10
             };
        },
        results: function (data, page) {  
              
             return {results: data.results};
        }
    },
    initSelection: function(element, callback) {
        
        
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
	}
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
	if ($("#cdrsearch").exists()){
	 $.ajax('/cabinet/cdr',{data:{},dataType:"jsonp",
		success: function(data){
	 		$(".selectspecial#confnumber").select2("data",{id: data.results[0].id, text: '<b>'+data.results[0].text+'<b>'});
			
		}
	}

	);
	};
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
}

    function add_category() {     
        var currentCount = $('.numbersetmarkup').length;
         var template = $('#numbersfieldset fieldset span').data('template');

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
		$('#newtrunkfieldset').empty();
		selects = $('input:regex(name,trunks\\w+)');
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

function reloadPickableDid(){
 	 $('#rowcont').append('<div><div class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div></div>');
 	
 	 var valeur = 10;
 	 $('.progress').show();
	  $('.bar').css('width', valeur+'%').attr('aria-valuenow', valeur);    
 	 var interval = setInterval(function(){
 		valeur  = valeur +30;
 		 
 	 	  $('.bar').css('width', valeur+'%').attr('aria-valuenow', valeur);    
 	}, 500);
 	 var result = $.ajax({ url: "/api/did/free", success:
			function(){
    		 $('#rowcont').empty();
				 var responseJson = $.parseJSON(result.responseText);
				 $.each(responseJson.data,function(key, did){
					 var digits;
					  did.digits.replace(/([\d]{3})([\d]{3})([\d]{2})([\d]{2})/g, function($0,$1,$2,$3,$4){
						 digits = " + 7 ("+$1+") "+$2+" - "+$3+" "+$4;
					 });
					 $('#rowcont').append("<span class='pickableradio nopadding span3 offset1'><input name='outgoingtrunk_did' type='radio' value='"+did.id+"' data-digits='"+digits+"'>"+digits+'</span>'); 
					 $('.pickableradio').css('cursor','pointer');
					 $('.pickableradio').click(function(event){
							$(event.currentTarget).children('input').first().prop( "checked", true );

						});
				 });
				 $('#rowcont').append("<span class='nopadding span3 offset1'><input name='refresh' id='refreshdidsbtn' class='btnaslink' type='button' value='еще'/></span>"); 
				 $('#refreshdidsbtn').click(function(){
					  reloadPickableDid();
				  });
				 var random = Math.round(Math.random()*10);
				 var randbtn = $("input[name='outgoingtrunk_did']").eq(random);
			//	 $("#largedid").text(randbtn.data('digits'));
				$("#largedid").text('не выбран');

				 var valeur = 100;
		 	 	  $('.bar').css('width', valeur+'%').attr('aria-valuenow', valeur);    
		 	 	  
		 	 	  $('.pickableradio').click(function(e){
						$("#largedid").text('резервирование...');
		 	 		 $(".wiznext").first().attr('disabled','disabled');;
		 	 		 
		 	 		 var json = $(e.target).parents('form').serializeArray();
 		 	 		  $.ajax('/api/did/free/'+json[0].value,{method:'PATCH',data:{status:'reserved'}, complete: 
		 	 			function(){
				 	 		 $("#largedid").text($(e.currentTarget).children('input').first().data('digits'));
				 	 		 $(".wiznext").first().removeAttr('disabled');
		 	 		  },
		 	 		  failed:function(resp){
		 	 			  
		 	 		  }
		 	 		  });
		 	 	  });
	 				/*randbtn.click();*/

 
			 },
			 error:function(){
	    		 $('#rowcont').empty();
				 alert('Ошибка загрузки, попробуйте еще раз!');
			 },
			 complete:function()
		 	 {
		 		 $('.progress').hide();
 		 		clearInterval(interval);
		 			$('#refreshdidsbtn').show();

		 	 }
			 }
 	  
 	 );
}
function submitWizInternal(options)
{
 	options.success();
 	var data = [];
 	$.each($('form.internallist'),function(i,v){
 		data.push($(v).serializeArray());	  		
 	});
 	 
 	$.ajax('',{type:'POST',  contentType: "application/json; charset=utf-8", dataType:'json',data:JSON.stringify(data)});
 }
$(function(){
 
$('.pickableradio').css('cursor','pointer');
if ($('#pickdid').exists())
	{	$('#refreshdidsbtn').hide();
	  reloadPickableDid();
	  $('#refreshdidsbtn').click(function(){
		  reloadPickableDid();
	  });
	}

 

$(".addinternalbtn").click(function(){ 	
 
	var element = $($(".templatelist").children().first()).clone().appendTo("#internallist");
  	select2dynamicBootStrap($(element).find("input").first());

	$(".removecurrent").click(function(e){ 	
  		submitWizInternal({success:function(){
 	 		$(e.target).parent().remove();
 		}});
	});
	
 
 });
 
});

$(function(){
	  $('.intlist').select2({
	      multiple: true,	     
	      width: '20em',
	      placeholder: 'номера',	  
	      query: function (query){
	          var data = {results: []};
  	          var preload_data = [];
 	          var numallowed = [];
 	          
 	         var context=this;
  	        var excludeNumbers =[];
  	        $('form.intlist').each(function(k,v){
  	        	var t = [];
  	          t = $(v).select2("data");
  	        	if (v!==context.element[0])
  	        		{
  	        			$(t).each(function(numkey,numrec){
  	    	        		excludeNumbers.push(numrec.id);
 	        			});
 	        			
  	        		};
   	        });
  	        
 	          
	          $.each($("form#numbersallowed").serializeArray(),function(i,v){
	        	  numallowed.push(parseInt(v.value));
	          });
 	        for (counter=100;counter<=999;counter++)
	      	{	        	
 	        	if	(($.inArray(Math.floor(counter/100)*100,numallowed)>=0)&&($.inArray(counter,excludeNumbers)<0))
	        		{
	        			preload_data.push({ id: counter, text: counter+''});
	        		}
	      	}
 	      
 	          $.each(preload_data, function(){
	              if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
	                  data.results.push({id: this.id, text: this.text });
	              }
	          });
 	          query.callback(data);
	      },	    
	  });
 	   $('.intlist').on("select2-selecting",(function(e,choice){
  		   var person = prompt("Имя сотрудника");
		   if (null===person)
		   {
			   e.preventDefault();
		   }
		   else
		   {
			   e.object.text='['+e.object.text+'] '+person;
		   }
 
	   }));
 	   if ($('.wizdataintnum').exists()){
	  		  var url = $(".wizdataintnum").first().data('url');
	  		  $.ajax(url,{type:'GET',  contentType: "application/json; charset=utf-8", dataType:'json',success:function(data){
	  		  		 $('#regularinternallist').select2("data", data.regularinternallist);
	  		  		 $('#ccoperatorlist').select2("data", data.ccoperatorlist);
		     	}});
  		};
 	   
 	   $('.intlist').on("change",(function(e){
  		  var url = $(".wizdataintnum").first().data('url');
  	    var numbers = {};
	        $('form.intlist').each(function(k,v){
	        	var t = [];
	          t = $(v).select2("data");
	          numbers[$(v)[0].id]=t;
	        });
	        console.log(numbers);
	     	$.ajax(url,{type:'PATCH',  contentType: "application/json; charset=utf-8", dataType:'json',data:JSON.stringify(numbers)});

 	   }));
 	 	if ($("#loadvpbxenv").exists())
 		{
  	 	 	 $('.progress').show();
  	 	  
 	  		var url = $("#loadvpbxenv").attr('action');
 	  		$.post(url,{},function(){
   		 		 
 	  				$('.progress').removeClass('active');
   	  				var url = $("#loadvpbxenv").data('postloadurl');
   	  			$('.modal').modal();  	  				
    	  				
 	  				$('body').load(url,function(){
 	  					$('.modal').modal();
  	 	  			//	alert("Поздравляем! Окружение виртуальной АТС успешно создано!");
 	  					$('.clkdownload').hover(function(e){
 	  			  	 		var target = e.target;
  	  			  	 		
 	  			 	 	});
 	  			 	 	$('.clkdownload').click(function(e){
 	  			 	 		var target = e.target;
 	  			 	 		url = $(target).data('url');
 	  			 	 		download(url);
 	  			 	 	});

 	  				});
 	  				 
 	  	  		}
 	  		);
 	  		 
 	 	}

 	 	$(function () {
 	 		if($('.fileupload').exists()){
 	 	    $('.fileupload').fileupload({
 	 	        dataType: 'json',
 	 	      maxFileSize:20000000,
  	 	        progressall:function (e, data) {
 	 	  	 	 	 $('.progress').show();
 	 	          var progress = parseInt(data.loaded / data.total * 100, 10);
  	 		  $('.bar').css('width', progress+'%').attr('aria-valuenow', progress);    
  	 	 	    
 	 	    },
 	 	    
 	 	  add: function (e, data) {
 	 		  
	  			$('.modal').modal();  	  				
	  			$('#modalcontainer').show();
  	            data.submit();
 	        },
 	         
 	 	        done: function (e, data) {
  		  			$('.modal').modal('toggle');  	  				
 		  			$('#modalcontainer').hide();

 	 	            	if (null===data.result.file.name)
 	 	            	{
 	 	                	alert('ошибка загрузки!');
 	 	                }
 	 	            	else
 	 	            	{
 	 	            		var player = $(e.target).closest('.jpcontainer').first().children('.jp-jplayer1').first();
 	 	                    var indexnum =  $(player).data('indexnum');

 	 	            		$(player).jPlayer("destroy");
 	 	            		
 	 	            		var defaultsound = $(player).data('defaultsound');
 	 	            		var myRegexp = /^(.+)\/([\d]{1,10})$/g;
 	 	            		var match = myRegexp.exec(defaultsound);
 	 	            		
 	 	                    $(player).data('defaultsound',match[1]+'/'+data.result.file.id);
  	 	                    $(player).data('indexnum',indexnum);
 
 	 	       	 			bootstrapJplayer1(player);
 	 	       	 			
 // 	 	            		console.log(
 	 	            		//console.log(data.result.file.name);
 	 	                    $(e.target).parent().find('a').text(data.result.file.name);
 	 	            				
  	 	            			//	$(this).parent().find('.jptitle').first().html(data.result.file.name)
  	 	            				//); 
// 	 	            		$(e.target).parent().first().text(data.result.file.name);    
 	 	            	}
 	 	        }
 	 	    });
 	 		}
 	 	});
  	 	
 	 	$('.uploadMediaDialog').click(
 	 			function(e){
 	 				e.preventDefault();
 	 				var idName = '#'+$(e.target).data('formname');
 	 				$(idName).trigger('click');  
 	 			}
 	 	);	 
 	 	$(".jp-jplayer1").each(function(i,player){
 	 		bootstrapJplayer1(player);
 	 	}
 	 	);
 	 	$('.mediacollapse').on('show.bs.collapse', function (event) {
 	 		var jpplayer = $(event.target).find(".jp-jplayer1").first();
 	 		$(jpplayer).jPlayer("load");
  	 	});
 	 	$('.mediaResetToDefault').click(
 	 	function(e){
 	 	 	$.ajax($(e.target).data('url'),{type:'PUT',  contentType: "application/json; charset=utf-8", dataType:'json',data:JSON.stringify({"default":true}),
 	 	 		success:function(response){
	            	var player = $(e.target).closest('.jpcontainer').first().children('.jp-jplayer1').first();
	            	var indexnum =  $(player).data('indexnum');

	            		$(player).jPlayer("destroy");
	            		
	            		var defaultsound = $(player).data('defaultsound');
	            		var myRegexp = /^(.+)\/([\d]{1,10})$/g;
	            		var match = myRegexp.exec(defaultsound);
	            		
	                    $(player).data('defaultsound',match[1]+'/'+response.result.id);
	                    $(player).data('indexnum',indexnum);
	 	       	 			bootstrapJplayer1(player);
 	 	                    $(e.target).parent().find('a').text(response.result.custname);

 	 	 		}
 	 	 	});	

 	 		}		
 	 	);
 	 	
  }
);
function bootstrapJplayer1(player)
{
	var sound = $(player).data('defaultsound');
 
		var indexnum = $(player).data('indexnum');
	     $(player).jPlayer({
	         ready: function() {
	             $(player).jPlayer("setMedia", {
	                  mp3: sound
	             });
	         },
	         preload:"none",
	         loop: false,
	         swfPath: "/js/Jplayer.swf",
	         supplied: "mp3",
	         cssSelectorAncestor: "#jp_container_"+indexnum
	     });
}
function download(path) 
{
    var ifrm = document.getElementById("frame");
    ifrm.src = path;
}