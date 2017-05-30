var 
MyFORM = MyFORM || {};
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

/**
 * Add module send respond message if in form is field 
 *
 * @param {Form} form
 * @param {String} field Optional name of field which active responde textarea
 * @return {String}
 */	
 
MyFORM.response = function (form, field){

	var html = '<div class="row form-group-sm"> ' +
		'<label class="col-sm-3 control-label">Text respond</label> ' +
		'<div class="col-sm-9"> ' +
		  '<textarea id="response" class="form-control input-sm" rows="5" disabled>Respond work if in form is field with name email</textarea> ' +
		'</div> ' +
	'</div>';
	field = field || 'email';
	
	$("#widget-form-options").append(html);

	return	function(){
		fields_with_data = h.getAllProperty('name', form.body);
		
		for (var i = 0; i < fields_with_data.length; i++) {
		    
		    if (fields_with_data[i] === field){
		    	$('#response').prop('disabled', false); break;
		    }
		    $('#response').prop('disabled', true);
		}
	}
}
