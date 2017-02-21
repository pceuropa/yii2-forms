/*
 * field.js v1.2.1
 * https://pceuropa.net/yii2-extensions/yii2-forms/manual
 * Licensed MIT © Rafal Marguzewicz
 */
 
 "use strict";


var MyFORM =  MyFORM || {};
MyFORM.field = (function(){
	console.log('field: 1.2.1');

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
	
	set: function (o) {  // get all property.value
        o = o || {};
	    for (var prop in o) {
			this[prop] = o[prop];
		}
	},
	
	setDataFieldFrom: function (cl) {

		var inputs = document.getElementById(this.body.field).getElementsByClassName(cl),
			input;
		for (var i = 0; i < inputs.length; i++) {
		
				input = inputs[i]
				if(input.type === 'checkbox'){
					if ( input.checked === true ) this.body[input.id] = input.checked;
				} else {
					if( h.is(input.value) ) this.body[input.id] = input.value;
						
				}
			}
	},
	
	setDataItemFrom: function (cl) {
		var o = {},
    	inputs = document.getElementById(this.body.field).getElementsByClassName(cl),
    	input;
		
		for (var i = 0; i < inputs.length; i++) {
			input = inputs[i]
			
			if(input.type === 'checkbox'){
				if ( input.checked === true ) o[input.id] = input.checked;
			} else {
				if ( h.is(input.value) ) o[input.id] = input.value;
			}
			
		}
		return o
	},
	addItem: function (field, item) {
		
		if(!h.is(item.value)){
			item.value = field.body.items.length + 1
		}
		field.body.items.push(item);
	},

// RENDER SECTION : preview Field, 	Item update
	render: function(){  // render field
		var preview  = $("#preview-field"), field = this;
			
			if(this.view){
				preview.html('(<a>html</a>) <br/><br/>' + field.html());
			} else {
				preview.html('(<a>text</a>) <br/><br/> <pre><code> </code></pre>').find('code').text(field.html());	
			}

		preview.find('a').click(function () {
			field.view = !(field.view);
			field.render();
		});
		
		this.disableButtonAddToForm();
		h.renderSelectUpdateItem(this)
		
	},
	
	disableButtonAddToForm:	function () {
	   var boolean = true;
   		boolean = ( this.body.field == 'description' || this.body.field == 'submit') ? false : !h.is(this.body.name)
   		
		$("#" + this.body.field).find('#add-to-form').prop( 'disabled', boolean);
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
		return el ? ' value="'+ el + '"' : '';
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
		
		var html_element = document.createElement("input");
		html_element.setAttribute("name", this.body.name);
		console.log(html_element);
		return  html_element.outerHTML;
	}
}


var input = {
	html: function() {
	
		return  this.div() +
				this.labelAttr() + 
				'\n\t<input' + this.attr('name', 'type', 'value', 'placeholder', 'id', 'class', 'data', 'require') + '>' +
				this.helpBlockAttr() + 
				this.divEnd();
	}
}

var textarea = {
	html: function() {
	
		var value = this.body.value ? this.body.value : '';
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
		
			return this.div() + this.is(this.body.textdescription) + this.divEnd();;
		}
	}

var submit = {
		color:	function () {
			return this.body['color'] ? 'style="color:'+ this.body['color'] +';"'  : '';
		},
		html: function() {
		return  this.div() +
				'\t<button type="submit" ' + this.color() + ' class="btn ' +  this.is(this.body.backgroundcolor) + '">' + this.is(this.body.label) + '</button>' +
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


