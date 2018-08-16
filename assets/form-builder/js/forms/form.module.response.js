
/**
 * Add module send respond message if in form is field 
 * @param {Form} form
 * @param {String} field Optional name of field which active responde textarea
 * @return {String}
 */	
 
var MyFORM = MyFORM || {};
MyFORM.response = function (){

	var html = 
        '<div class="form-group-sm">' +
        '<div class="input-group">' +
        '<div class="input-group-addon">Email<br/>response</div>' +
		'<textarea id="response" class="form-control" rows="5" disabled>Respond work if in form is field with name email</textarea> ' +
        '</div></div>';
	
	$("#widget-form-options").append(html);

	return	function(form){
		$('#response').prop('disabled', form.fields_with_data.indexOf('email') < 0);
	}
}
