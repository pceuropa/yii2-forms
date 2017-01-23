var MyFORM =  MyFORM || {};
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
console.log('template');

MyFORM.template = function (form){
var version = '1.0.0',
 	temp = [{
	"title": "Template1",
	"body": [
	    [
	        { "field": "input", "name": "imie", "type": "text", "label": "Imię", "width": "col-md-6", },
	        { "field": "input", "name": "nazwisko", "type": "text", "label": "nazwisko", "width": "col-md-6", "require": true, }
	    ],
	    [
	        { "field": "input", "name": "email", "type": "email", "label": "email", "width": "col-md-6", "require": true, },
	        { "field": "input", "name": "has_o", "type": "password", "label": "hasło", "width": "col-md-6", }
	    ],
	    [
	        { "field": "submit", "label": "Add", "width": "col-md-6" }
	    ],
	]},
	{
	"title": "Template2",
	"body": [
	    [
	        { "field": "input", "name": "imie", "type": "text", "label": "Imię1", "width": "col-md-6", },
	        { "field": "input", "name": "nazwisko1", "type": "text", "label": "nazwisko", "width": "col-md-6", "require": true, }
	    ],
	    [
	        { "field": "input", "name": "email", "type": "email", "label": "email2", "width": "col-md-6", "require": true, },
	        { "field": "input", "name": "has_o", "type": "password", "label": "hasło2", "width": "col-md-6", }
	    ],
	]}
];

var div1 = document.createElement("div"),

			innerHTML = '<label class="col-sm-4 control-label">Template</label>' +
						'<div class="col-sm-8">' +
							'<select id="template" class="form-control input-sm"><option>Example template</option></select>' +
						'</div> ';
						
(function(){

		div1.setAttribute('class', 'form-group');
		div1.innerHTML = innerHTML;
		
		$(div1).find('#template').append( function() {
			var option, t, options = document.createElement('div');
			
			h.each(temp, function (i) {
				t = temp[i];
			    option = document.createElement('option');
			    h.setAttribute(option, 'value', i);
			    option.appendChild(document.createTextNode(t.title));
			    options.appendChild(option);
			})
	
			
			return options.innerHTML;
		})
		$(document).ready(function(){  
		$("#form .widgets").append( div1.outerHTML );
		
			$("#template").change(function(){
				if(!form.body.length){
					form.body = temp[this.value].body
					form.render()
				} 
			})
		});
		
})()

return temp;
};
		
		
		/*
		
<div class="form-group">
	<label class="col-sm-4 control-label">Template</label>
	<div class="col-sm-8">
		<select id="template" class="form-control input-sm">
			<option value="1">template 1</option>
		</select>
	</div>
</div>
	*/	
		
	


