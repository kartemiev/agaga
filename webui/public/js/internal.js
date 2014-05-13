function showPass(inputfld, btnfld)
{
	$('form').find(inputfld).each(function() {
		   $("<input type='text' />").attr({ name: this.name, value: this.value }).insertBefore(this);
		}).remove();
	$(btnfld).attr('value','скрыть');
}
function hidePass(inputfld, btnfld)
{
	$('form').find(inputfld).each(function() {
		   $("<input type='password' />").attr({ name: this.name, value: this.value }).insertBefore(this);
		}).remove();
	$(btnfld).attr('value','показать');
}

var inputsecretSelector = 'input[name="secret"]';
var showButtonSelector = '#showpass';
var copyButtonSelector = '#copypass';
var clearButtonSelector = '#clearpass';
var generateButtonSelector = '#generatepass';

$(
function()
{
	$(showButtonSelector).show();
	$(copyButtonSelector).show();
	$(clearButtonSelector).show();
	$(generateButtonSelector).show();

	$(copyButtonSelector).zclip({
		path:'/js/ZeroClipboard.swf',
		copy:function(){return $(inputsecretSelector).val();},		
		afterCopy:function(){
			/* alert('скопировано!');*/
			}
		});
 	
	$(showButtonSelector).click(function(){
		if ("password" === $(inputsecretSelector).attr('type'))
			{
				showPass(inputsecretSelector, showButtonSelector);
			}
			else
			{
				hidePass(inputsecretSelector, showButtonSelector);
			}
		
	}
	);
	
	$(clearButtonSelector).click(function(){
		$(inputsecretSelector).val('');
		}
	); 	
	
	$(generateButtonSelector).click(function()
	{
		$.getJSON('/cabinet/internal/generate', function(data) {			  			 
			$(inputsecretSelector).val(data.pwd);
			showPass(inputsecretSelector, showButtonSelector);
 		}
	);
	});
	
	$(inputsecretSelector).bind('blur mouseout',function(){
		hidePass(inputsecretSelector, showButtonSelector);		
		});
}
);
