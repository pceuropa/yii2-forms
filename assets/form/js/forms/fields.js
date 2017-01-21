"use strict";
//#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net
var MyFORM =  MyFORM || {};
MyFORM.field = (function(){


var factory = function(o) {
	this.body = o  || {};
	this.init();
	
};

factory.prototype = {
	constructor: factory,
	view: true,
	init: function () {
		this.set(MyFORM.field[this.body.field])
	},
	
	uiHelper: function () {
		var field = this;

		(function data() {
			var inputs = document.getElementById(field.body.field).getElementsByClassName("data-source");
			for (var i = 0; i < inputs.length; i++) {
					field.body[inputs[i].id] = (inputs[i].type === 'checkbox') ? inputs[i].checked : inputs[i].value;
				}
		})();

		(function helpForUser() {
			if($("#" + field.body.field + " #name").val() == '' ){
				$(this).css( "color", "red" );
				$(this).val(field.body.field) ;
			}

		})();
		
	},


	set: function (o) {
        o = o || {};
	    for (var prop in o) {
			this[prop] = o[prop];
		}
	},
	
	addItem: function () {
		try {
			var items = document.getElementById(this.body.field).getElementsByClassName("itemField"), item = {};
			
			for (var i = 0; i < items.length; i++) {
				item[items[i].id] = (items[i].type === 'checkbox') ? items[i].checked : items[i].value;
			}
			
			this.body.items.push(item);
			this.render();
		}
		catch(e) {
            console.log(e);
            
			alert('Error add item to field: bad id of div')
		}
		
	},
	
   


// RENDER SECTION : preview Field, 	Item update
	render: function(){  // render field
		var preview  = $("#preview-field"), field = this;
			
			if(this.view){
				preview.html('<p>Preview field: (<a>html</a>) </p>' + field.html());
			} else {
				preview.html('<p>Preview field: (<a>text</a>)</p><pre><code> </code></pre></p>').find('code').text(field.html());	
			}

		preview.find('a').click(function () {
			field.view = !(field.view);
			field.render();
		});
		
		//this.renderUpdateItemField();
		
	},
	
    renderUpdateItemField: function(){
        var field = this;
        
        if(this.body.hasOwnProperty('items')){
        if(this.body.items.length){
                $("#" + field.body.field + " .select-item-to-change").html(
                    (function () {
                        var i = 0, text = '', itemOption = '';

                        for (i; i < field.body.items.length; i++) {
					        text = field.body.items[i].text ? field.body.items[i].text : '';
					        itemOption += '<option value="' + i + '">'+(i + 1) +'. ' + text +'</option>';
				        }

				        return '<select class="change-item form-control input-sm"> <option selected>Change item</option>'+ itemOption + '</select>';  
                    })()
                );
        }}	
	},


	is: function (value) {
		return value ? value : '';
	},

	typeAttr: function () {
		return this.body.type ? ' type="'+ this.body.type + '"' : '';
	},
	labelAttr: function () {
		var require = '';
		if (this.body.require) { require = ' *';}
		return this.body.label ? '\n\t<label>' + this.body.label  + require + '</label>' : '';
	},
	nameAttr: function (multi) {
		var multi = multi || false
		if(multi){
			return this.body['name'] ? ' name="'+ this.body['name'] + '[]"' : '';
		} else {
			return this.body['name'] ? ' name="'+ this.body['name'] + '"' : '';
		}
		
	},
	valueAttr: function () {
	
		return this.body.value ? ' value="'+ this.body.value + '"' : ' ';
	},
	placeholderAttr: function () {
		return this.body.placeholder ? ' placeholder="'+ this.body.placeholder + '"' : '';
	},
	idAttr: function () {
		return this.body.id ? ' id="'+ this.body.id + '"' : '';
	},
	classAttr: function () {
		return this.body['class'] ? ' class="form-control '+ this.body['class'] + '"' : ' class="form-control"';
	},
	dataAttr: function () {
		return this.body.data ? ' data="'+ this.body.data + '"' : '';
	},
	rowsAttr: function () {
		return this.body.rows ? ' rows="'+ this.body.rows + '"' : '';
	},
	checkedAttr: function () {
		return this.body.checked ? ' checked' : '';
	},
	requireAttr: function () {
		return this.body.require ? ' required' : '';
	},
	checkedAttr: function () {
		return this.body.require ? ' checked' : '';
	},
	helpBlockAttr: function () {
		return this.body.helpBlock ? '\n\t<span class="help-block">' + this.body.helpBlock + '</span>' : '';
	},
	div: function () {
		return '<div class="form-group ' + this.body.width + '">';
	},

	divEnd: function () {
		return '\n</div>';
	},
 
	attr: function(){
		var i, t = '', max = arguments.length;

		for (var i = 0;  i < max; i += 1){
			t += this[arguments[i] + 'Attr']();
		}
		return t;
	},
	el: function(j){
		var i, t = '', fn, max = arguments.length;

		for (var i = 1;  i < max; i += 1){
			fn = arguments[i] + 'El';
			t += this[fn](j);
		}
		return t;
	},
	labelEl: function (i) {
			var text = this.body.items[i].text;
			return text ? text : '';
	},
	valueEl: function (i) {
		var el = this.body.items[i].value;
		return el ? ' value="'+ el + '"' : ' value="'+ i + '"';
	},
	idEl: function (i) {
		var el = this.body.items[i].id;
		return  el ? ' id="'+ el + '"' : '';
	},
	classEl: function (i) {
		var el = this.body.items[i]['class'];
		return  el ? ' class="'+ el + '"' : '';
	},
	checkedEl: function (i) {
		return this.body.items[i].checked ? ' checked' : '';
	},
	selectedEl: function (i) {
		return this.body.items[i].checked ? ' selected' : '';
	},
	requireEl: function () {
		return this.require ? ' required' : '';
	},

	inputs: function(){
		var i = 0, input = '';

		if(typeof this.body.items === "undefined"){
			this.body.items = []
		}
		


		for (i; i < this.body.items.length; i++) {
		    input += this.input(i) 
		}
		return input;
	},
	inputHtml: function (type, i) {
		return '<input type="'+ this.is(type) +'"'+ this.attr('name') + this.el(i, 'value', 'id', 'class', 'checked', 'require') +'>'+ this.labelEl(i);// + this.editElement(i);
	},


	editElement: function (i) {
		return Form.prototype.editEl.call(this, i)
	},
	glyphicon: function (index, cl) {
			return '<span class="glyphicon ' + cl + '" data-index="' + index + '" aria-hidden="true"></span>';
	},
	
    // depraced
	deleteItem: function(index){
		if(index){
            this.body.items.splice(index, 1);
		    this.render();
        } else {
            console.log('Delete item by index:');
            throw index
        }
        
	},
    // depraced
	cloneItem: function(index){
        if(index){
            var o = this.body.items[index];
		    this.body.items.splice(index, 0, o); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
		    this.render();  
        } else {
            console.log('Clone item by index:');
            throw index 
        }
        
		
	}
} // end Field()





var input = {
	html: function() {
	
		return  this.div() +
				this.labelAttr() + 
				'\n\t<input name=\"DynamicModel[input]\" '+ this.attr('type', 'value', 'placeholder', 'id', 'class', 'data', 'require') + '>' +
				this.helpBlockAttr() + 
				this.divEnd();
	}
}

var textarea = {
	html: function() {
		var value = this.value ? this.value : '';
		return  this.div() +
				this.labelAttr() +
				'\t<textarea ' + this.attr('name', 'id', 'class', 'data', 'rows', 'placeholder', 'require') + '>' + value + '</textarea>'+
				this.helpBlockAttr() +
				this.divEnd();
	}
}

var radio = {
	html: function() {
		return  this.div() +
				this.labelAttr() +
				this.inputs() +
				this.helpBlockAttr() +
				this.divEnd();
	},
	labelAttr: function () {
		var req = '';
		if (this.body.require) { req = ' *';}
		return this.body.label ? '\t<p>' + this.body.label + req + '</p>' : '';
	},
	
	input: function(i){
		
		return '\n\t<div class="radio"><label>' + this.inputHtml('radio', i) + '<label></div>';
	},
		
}

var checkbox = {
	html: function() {
			return  this.div() +
			this.labelAttr() +
			this.inputs() +
			this.helpBlockAttr() +
			this.divEnd();
	},
	input: function(i){
		return '\n\t<div class="checkbox"><label><input type="checkbox"'+ this.nameAttr('multi') + this.el(i, 'value', 'id', 'class', 'checked', 'require') +'>'+ this.labelEl(i) +'<label></div>';
	}
}

var select = {
		html: function() { 
			return this.div() +
				this.labelAttr() +
				'\n\t<select ' + this.attr('id', 'class', 'name', 'require') + '>' +this.inputs() + '\n\t</select>' +
				this.helpBlockAttr() +
				this.divEnd();
		},
		input: function(i){
			return '\n\t\t<option ' + this.el(i ,'value', 'selected') + '>' + this.labelEl(i) + '</option>';
		}
	}
	
var description = {
		
		classAttr: function () {
			return this.body['class'] ? ' '+ this.body['class'] : '';
		},
		div: function () {
			return '<div ' + this.idAttr() + ' class="form-group '+ this.body.width + this.classAttr() +'">';
		},
		
		html: function() { 
			return this.div() + this.is(this.body.description) + this.divEnd();;
		}
	}

var submit = {
	
		html: function() {
		return  this.div() +
				'\t<button type="submit" class="btn btn-default">' + this.is(this.body.label) + '</button>' +
				this.divEnd();
		}
	}



return {
		factory: factory,
		input: input,
		textarea: textarea,
		radio: radio,
		checkbox: checkbox,
		select: select,
		description: description,
		submit: submit,
	}

})();


