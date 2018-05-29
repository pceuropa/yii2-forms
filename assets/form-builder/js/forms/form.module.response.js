
/**
 * Add module send respond message if in form is field 
 * @param {Form} form
 * @param {String} field Optional name of field which active responde textarea
 * @return {String}
 */	
 
var MyFORM = MyFORM || {};
MyFORM.response = function (){

	var html = '<div class="row form-group-sm"> ' +
		'<label class="col-sm-3 control-label">Text respond</label> ' +
		'<div class="col-sm-9"> ' +
		  '<textarea id="response" class="form-control input-sm" rows="5" disabled>Respond work if in form is field with name email</textarea> ' +
		'</div></div>';
	
	$("#widget-form-options").append(html);

	return	function(form){
		$('#response').prop('disabled', form.fields_with_data.indexOf('email') < 0);
	}
}
