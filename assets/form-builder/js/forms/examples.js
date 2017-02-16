var MyFORM =  MyFORM || {};
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

MyFORM.template = function (form){
var version = '1.1.1',
	id_selector = "#examples-form",
 	temp = [{
	"title": "example 1",
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
	"title": "example 2",
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

	innerHTML = '<label class="col-sm-4 control-label">Examples</label>' +
				'<div class="col-sm-8">' +
					'<select id="examples-form" class="form-control input-sm"><option> </option></select>' +
				'</div> ';
						
	(function(){

			div1.setAttribute('class', 'form-group');
			div1.innerHTML = innerHTML;
		
			$(div1).find(id_selector).append( function() {
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
			$("#form #widget-form-options").append( div1.outerHTML );
		
				$(id_selector).change(function(){
					if(!form.body.length){
						form.body = temp[this.value].body
						form.render()
					} 
				})
			});
		
	})()
	
	console.log('template: ' + version);
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
		
	


