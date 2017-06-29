 /**
 * Create fields as Htmlelement for forms.js. Provides functions help set field data, add|delete|update items of fields
 * @author Rafal Marguzewicz
 * @license MIT
 * @constructor
 * @param {Object} o - field data ex. {"field": "radio", "name": "string", "items": []}
 * @return {Object} - field data and helpers functions
 */
 

 "use strict";
var MyFORM =  MyFORM || {};
MyFORM.field = (function(){
	console.log('field: 2.0.0');

var factory = function(o) {
	this.body = o  || {};

    if (!h.is(this.body.field)){
        console.log("field type not exist");
    }
	this.init();
};

factory.prototype = {

	constructor: factory,
	view: true,

	init: function () {
        var field_data = MyFORM.field[this.body.field]
		h.inheritAll(this, field_data)
	},
	
    /**
    * Set default values of input from field template
    * @param {String} cl - class of inputs where this functions set default data
    * @return {undefined}
    */
    setDefaultValuesInputs: function() {
        var input;
        if (!this.data) {
            return;
        }
        for (var prop in this.data) {
          input = document.querySelector("#"+ this.body.field+ " #"+ prop);
          if (input.value == '') {
            input.value = this.data[prop];
          }
          console.log(input);
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
    

    /**
    * Set data items. Get data from class {cl} inputs
    * @param {String} cl - CSS class
    * @return {Object} item data
    */
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

    /**
    * Add item to field (radio|checkbox|select)
    * @param {Field} field  
    * @param {Object} field  ex. {"text": "stringText", "value": null, "checked": true}
    * @return {undefined}
    */
	addItem: function (field, item) {
		if(!h.is(item.value)){
			item.value = field.body.items.length + 1
		}
		field.body.items.push(item);
	},

    /**
    * Render field in div#preview-field. Render select (update-item) if field have items 
    * @see disableButtonAddToForm()
    * @see renderSelectUpdateItem()
    * @return {string}
    */
	render: function(){  // render field
		var preview  = $("#preview-field"),
            field = this,
            html = field.html().innerHTML;
			
			if(this.view){
				preview.html('(<a>html</a>) <br/><br/>' + html);
			} else {
				preview.html('(<a>text</a>) <br/><br/> <pre><code> </code></pre>').find('code').text(html);	
			}

		preview.find('a').click(function () {
			field.view = !(field.view);
			field.render();
		});
		
		this.disableButtonAddToForm();
		this.renderSelectUpdateItem(this)
	},
	
    /**
     * Render Select input to select to update items
     * @param {Object} field
     * @return {String} render select tag
    */
    renderSelectUpdateItem: function(field) {
        if(!h.is(field)) { return; }

        if(field.body.hasOwnProperty('items')) {
            if(field.body.items.length) {

                $("#" + field.body.field + " .select-item-to-change").html(
                (function () {
                    var i = 0, text = '', itemOption = '';

                    for (i; i < field.body.items.length; i++) {
                        text = field.body.items[i].text ? field.body.items[i].text : '';
                        itemOption += '<option value="' + i + '">'+(i + 1) +'. ' + h.subString(text, 60) +'</option>';
                    }
                    return '<select class="change-item form-control input-sm"><option>Update</option>'+ itemOption + '</select>';
                })()
                );
            } else {
                $("#" + field.body.field + " .select-item-to-change").empty()
            }

        }
    },

	disableButtonAddToForm:	function () {
	    var boolean = true;
   		boolean = ( this.body.field == 'description' || this.body.field == 'submit') ? false : !h.is(this.body.name)
   		
		$("#" + this.body.field).find('#add-to-form').prop( 'disabled', boolean);
	},

    /**
    * Set label for fiels
    * @param {htmlElement} element - element.appendChild(label)
    */
    label: function(element) {
        var label, textlabel;
        if (!h.is(this.body.label)) {
            return;
        }
        textlabel = this.body.require ? this.body.label + ' *' : this.body.label;
        label = document.createElement("label");
        label.appendChild(document.createTextNode(textlabel));
        element.appendChild(label);
    },
    
    /**
    * Generate list inputs and append to parent
    * @param {HtmlElement} parent - to this element will adds inputs
    * @return {undefined}
    */
	inputs: function(parent){
        var i, div, text, item, input, label, name;
		if(!h.is(this.body.items)){ this.body.items = [] }
        name = (this.body.field === 'radio')? "name" : {"name": this.body.name + '[]'};
		for (i =0; i < this.body.items.length; i++) {
            item = this.body.items[i]

            div = this.createField("div", [{"class": this.body.field}]),
            label = document.createElement("label");
            input = this.createField("input", [{"type": this.body.field}, name, {"value": item.value}, {"checked": item.checked}]),
            text = document.createTextNode(item.text);

            div.appendChild(label).appendChild(input);
            label.appendChild(text);
            parent.appendChild(document.createTextNode("\n\t"));
            parent.appendChild(div);
		}
	},

	inputHtml: function (type, i) {
		return '<input type="'+ this.is(type) +'"'+ this.attr('name') + this.el(i, 'value', 'id', 'class', 'checked', 'require') +'>'+ this.labelEl(i);
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
	},

    /**
    * Create div element and set attributes
    * @param {Object} param - desc
    * @returm {Boolean}
    */
    div: function() {
        var div = this.createField("div", [{"class": "form-group "+ this.body.width}]); 
        return div;
    },

    /**
    * Set attributes for field
    * @param {htmlElement} field
    * @param {Array} attributes - list attributes to check
    */
    setAttributes: function(field, attributes) {
        for (var i = 0, len = attributes.length; i < len; i++) {
            var attribute = attributes[i]

            if (h.isObject(attribute) && h.is(h.firstValue(attribute))) {
                h.setAttribute(field, h.firstProp(attribute), h.firstValue(attribute));
            }

            if (h.isString(attribute)) {
                h.setAttribute(field, attribute, this.body[attribute]);
            }
        } 
    },

    /**
    * Create field, set attributes and append
    * @param {String} param - name created Html element
    * @returm {HtmlElement}
    */
    createField: function(param, listAttributes) {
        var field = document.createElement(param);
        this.setAttributes(field, listAttributes);
        return field;
    },

    /**
    * Create text node
    * @param {String} text - if param is string will be convert on text node
    * @returm {textNode}
    */
    createTextNode: function(text) {
        if (h.isString(text)) {
            return document.createTextNode(text);
        } 
        return document.createElement(false);
    },
    
    /**
    * Create description (helpBlock) under field
    * @param {Object} param - desc
    * @returm {HtmlElement}
    */
    helpBlock: function(parent) {
        if (h.is(this.body.helpBlock)) {
            parent.appendChild(document.createTextNode(this.body.helpBlock));
        }
    },

    /**
    * Append element
    * @param {HTMLElement} child - desc
    * @returm {this}
    */
    append: function(child) {
        this.child = child; 
        return this;
    },

    /**
    * set Defalut value to field
    * @returm {Boolean}
    */
    setDefaultValue: function(element, param) {
        if (h.is(this.body[param])) {
            element.defaultValue = this.body[param];  
        }
    },

    /**
    * Select parent where add child element 
    * @param {HTMLElement} parent 
    * @returm {Boolean}
    */
    to: function(parent) {
      if (h.is(this.child)) {
            parent.appendChild(this.child); 
      }
    },
    is: function (value) {
           return value ? value : '';
    },

    
}

var input = {
    data: {"class": "form-control"}, 
    html: function() {
    var field = this.createField("input", ["type", "name", "placeholder", "require", "value", "id", "class"]),
            div = this.div();

            this.label(div);
            div.appendChild(field);
            this.helpBlock(div);
		return  div;
	}
}

var textarea = {
    data: {"class": "form-control"}, 
	html: function() {
	    
		var field = this.createField("textarea", ["name", "placeholder", "require", "id", "class", "rows" ]),
            div = this.div();

            this.label(div);
            div.appendChild(field);
            this.setDefaultValue(field, "value");
            this.helpBlock(div);
		return  div;
    }
}

var radio = {
    data: {"class": "form-control"}, 
	html: function() {
        var div = this.div();
            this.label(div);
            this.inputs(div)
            div.appendChild(document.createTextNode("\n\t"));
            this.helpBlock(div);
		return  div;
}}

var checkbox = {
    data: {"class": "form-control"}, 
	html: function() {
        var div = this.div();

            this.label(div);
            this.inputs(div)
            div.appendChild(document.createTextNode("\n\t"));
            this.helpBlock(div);
		return  div;
}}

var select = {
    data: {"class": "form-control"}, 
    html: function() { 
        var div = this.div();
            this.label(div);
            this.select(div)
            div.appendChild(document.createTextNode("\n\t"));
            this.helpBlock(div);
		return  div;
	},
	select: function(parent){
        var i, text, item, option, select = this.createField("select", ['class', 'id', 'name']);

		if(!h.is(this.body.items)){ this.body.items = [] }

            select.appendChild(document.createTextNode("\n\t\t"));
		for (i =0; i < this.body.items.length; i++) {
            item = this.body.items[i]

            option = this.createField("option", [{"value": item.value}, {"selected": item.selected}]);
            text = document.createTextNode(item.text);

            select.appendChild(option).appendChild(text);
            select.appendChild(document.createTextNode("\n\t\t"));
		}
            parent.appendChild(document.createTextNode("\n\t\t"));
            parent.appendChild(select);
	},
    template: {
          div: {
            label: {},
            select: {attributes: {}},
            text: {value:''},
            attributes: {},
          }
       }
	}
	
var description = {
		
		html: function() { 
		    var div = this.createField("div", ['id', {"class": this.body.class}]);
                if(h.is(this.body.width)){
                    div.classList.add(this.body.width);
                }
                div.innerHTML = this.is(this.body.textdescription);
			return div;
		}
	}

var submit = {

	html: function() {
		var submit = this.createField("button", ["id", {"class": "btn"}]),
            div = this.div();

                if(h.is(this.body.width)){
                    submit.classList.add(this.body.backgroundcolor);
                }
                if(h.is(this.body.class)){
                    submit.classList.add(this.body.class);
                }
                submit.innerHTML = this.is(this.body.label);
            div.appendChild(submit);
		return  div;
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


