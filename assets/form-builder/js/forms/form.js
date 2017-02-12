"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net


var MyFORM =  MyFORM || {};
MyFORM = (function(){
console.log('form: 1.2.1');
var Form = function (){

		//this.url = null;
		this.title =  "FormBuilder";
		//this.action = "";
		this.method = "post";
		this.language = "English"; 
		this.body = [];
		
		
	};
	
	Form.prototype = {
		// filter after save
		hello: 'hello Vege',
		fields_with_data: [],  // array for false autosave
		constructor: Form,
		viewMode: 'html',
		time_out: 1,
		div_form: $("#preview-form"),
		options_form: $("#form"),
		map: { index: "0", row: "0" },
		c: {
			get: false, 
			save: true, 
			autosave: false, 
			controller_url: document.URL, 
		},
	// create get false, save true, autsave false
	// update get true, save true, autsave false/true
	
	init: function (config) {
		
		h.inheritAll(this.c, config)
		this.get();
		if(this.c.autosave){
			this.autosaveButton();
			Form.prototype.time_out = 1000;
		}
		
		return MyFORM.controller(this, new MyFORM.field.factory() );
		
	},

	
	autosaveButton: function () {
		if(this.c.autosave){
			$("#save-form").html('autosave mode').prop('disabled', true);
		}
		
	},
	
    clear: function (o) {
        var notReference = {} 
        
        for (var prop in o) {
            if (o.hasOwnProperty(prop) && o[prop]){
            	
		        if(prop === 'name'){
		        	o[prop] = this.uniqueName( o[prop] );
		        }
		        
		        if(prop === 'items'){
		        
				    for (var i = 0; i < o[prop].length; i++) {
				    
						if( !h.is( o[prop][i].value ) ){
		    	        		o[prop][i].value = (i + 1);
		    	        	}
			    	}
			    	
	        	}
	        	
	        	notReference[prop] = o[prop];
	        }
            
        }
        return notReference;
    },
    
	uniqueName: function (name){
		var q = this.fields_with_data,
	  		name = h.replaceSpaces(name);
	  	
	  	if( $.inArray(name, this.fields_with_data) ){
	  		name = name + '_2'
	  	}
		this.fields_with_data.push(name);
		return name;
	},
	
	
	get: function (){
			var form = this;
			if(this.c.get){
				$.getJSON(this.c.controller_url, function(r){
				
					console.log('upload from base correct');
					form.generate(r)
				});
			}
			
			
		},
	
	
	save: function (){
			var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			
			if(!this.c.save) return false;
			
			data = {form_data: JSON.stringify(form), title: form.title, url: form.url,  _csrf : csrfToken };

			$.post( this.c.controller_url, data, function (r){
				
				if (r.success === true) { 
					console.log('save in base correct');
					form.successSave();
					if (r.url){ window.location.href = r.url;}
				} else {
					form.errorSave(r.success);
				} 
				
			});
				
	},
	
	editName: function(old_name, new_name){
		var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			
			if(this.c.autosave){
				data = {change: {old: old_name, new: new_name, body: JSON.stringify(form)}, _csrf : csrfToken };

				$.post( this.c.controller_url, data, function (r){
					if (r.success === true) { 
						console.log('new name change correct');
					}
				});
			}
			
	},
	
	
	setValueInputOptions: function () {
		this.options_form.find('#title').val(this.title);
		this.options_form.find('#url').val(this.url);
	},
	errorSave: function (o) {
		console.log(h.firstProp(o));
		
		var save_form = $( "#save-form" ), clone = save_form.clone();
		
		save_form
			.addClass("btn-danger" )
			.prop('disabled', true )
			.text(h.firstValue(o));
		
		window.setTimeout(function() { save_form.replaceWith(clone); }, 3111);
	
	},
	
	successSave: function () {
		
		var save_form = $( "#save-form" ), clone = save_form.clone();
		
		save_form
			.addClass("btn-success" )
			.prop('disabled', true )
			.text('Saved form correctly');
		
		window.setTimeout(function() { save_form.replaceWith(clone); }, 1111);
		
		
	},
		
	add: function (o){
			try {
				if (o.hasOwnProperty('field') ){
			
					this.body.push([this.clear(o)]);
				
					if (this.c.autosave){
						$.post( this.c.controller_url, {add: o});
					} 
				
					this.render();
				} 	
			}
			catch (err) {
				console.log(err);
				alert('Error add field to form: bad data')
			}
		},
		
	cloneField: function(row, index){
	
			var 
				first = this.body[row][index], 
				o = jQuery.extend(true, {}, first);
			
			if (o.hasOwnProperty('label')){
				o.label = first.label + '_2'
			} 
			
			o.name = first.name + '_2'
			
			this.body[row].splice(index + 1, 0, o); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
			
			if(this.c.autosave){
				if (o.hasOwnProperty('name')){
					$.post( this.c.controller_url, {add_field: o} );
				}
			}
			
			this.render();
			
	},
 
	deleteField: function(row, index){
	
		var field = this.body[row][index]
			try {
			
				if( this.body[row].splice(index, 1) ){
				
					if(this.c.autosave && this.c.save){
						$.post( this.c.controller_url, {delete: field.name}, function (r) {
							if (r.success != true) {console.log(r);}
						});
					};
					console.log('Delete item [', row , index, ']');
					this.render();
				}
				
			}
			
			catch(err){
				console.log('Item [', row , index, '] not exsist');
				
			}
		},

    // depraced
	addItem: function () {
         console.log('add item to field in form');
         
		try {
			var items = document.getElementById('update').getElementsByClassName("itemField"), item = {};
			
			for (var i = 0; i < items.length; i++) {
				item[items[i].id] = (items[i].type === 'checkbox') ? items[i].checked : items[i].value;
			}
			
			this.body[this.map.row][this.map.index].items.push(item);
			this.render();
		} catch(e) {
		
            console.log(e);
			alert('Error add item to field: bad id of div')
		}
		
	},
	
      // depraced
	cloneItem: function(row, index, id){
				var clone = {}, element = this.body[row][index]['items'][id];
					for (var prop in element){
						if (element.hasOwnProperty(prop)){
				        	clone[prop] = element[prop];
						}
					}
			this.body[row][index].items.splice(id, 0, clone);
			this.render();
		},

    // depraced
	deleteItem: function (row, index, id){
			this.body[row][index]['items'].splice(id, 1);
			this.render();
		},

	generate: function(o){
 			h.inheritAll(this, o);
		    if(this.body.length !== 0) this.render('off')
		    
		    this.setValueInputOptions();
			this.fields_with_data = h.getAllProperty('name', this.body);
		},


// <---- View
	render: function(){
			switch(Form.prototype.viewMode){
				case 'html': this.div_form.html(this.html()); this.sort(this); break;
			    case 'text': this.div_form.html('<pre><code> </code></pre>').find('code').text(this.html()); break;
				case 'json': this.div_form.html('<pre><code> </code></pre>').find('code').text(JSON.stringify(this, null, 4)); break;
				case 'yii2': this.div_form.html('<pre><code> </code></pre>').find('code').text('Yii2'); break;
			    default: 	throw "View mode error, check form.viewMode";
			}
			if(this.c.autosave && arguments[0] !== 'off' ){
				this.save();
			}
			
			this.preventNotValidaData();
			
			
	},
	preventNotValidaData: function () {
		$("#save-form").prop('disabled', !(h.isString(this.title) && h.isString(this.url)))	;
	},
	
	attr: function(){
			var i, temp = '', max = arguments.length;
	
			for (var i = 0;  i < max; i += 1){
				temp += this[arguments[i] + 'Attr']();
			}
			return temp;
		},

	idAttr: function (){
			return this.id ? ' id="'+ this.id + '"' : '';
		},
	classAttr: function (){
			return this['class'] ? ' class=" '+ this['class'] + '"' : ' class=""';
		},
	
	// rows -> row - > fields - > field - > render

	rows: function(){
		    var rows = '', form = this;
			if(form.body.length == 0) return '';
			
			h.each(form.body, function (i){ rows += form.row(i) })
	    return rows;
		},

	row: function(id){
		    return '\n<div id="row'+ id +'" class="row">\n'+ this.fields(id) +' \n</div>\n';
		}, 
	fields: function(id){
		    var fields = '';
		    for (var i = 0, max = this.body[id].length; i < max; i++){
		        fields += this.field(id, i);
		    }
    	return fields;
		},

	field: function(row, index){
			var f = this.body[row][index],
			field = new MyFORM.field.factory(f);
			
			// test ----- console.log(row, index, f.field, Array(20 - f.field.length).join("-"), field);

			if(Form.prototype.viewMode === 'html'){
				
				field.divEnd = function (){
					return Form.prototype.edit(row, index) +  '\n</div>\n';
				}
			}
			
		return field.html();
		},
		
	

	html: function (){
			 return '<form  action="' + this.action + '" method="' + this.method + '" ' + this.attr('id', 'class') + '>' +
							this.rows() + '\n</form>';
		},
	setEdit: function (row, index){
			Form.prototype.beforeEndDiv = this.edit(row, index);
		},

	setView: function(view){
			Form.prototype.viewMode = view || '';
		},
	

	edit: function(row, index){
			function glyphicon(row, index, cl){
				return '<span class="glyphicon ' + cl + '" data-row="' + row + '" data-index="' + index + '" aria-hidden="true"></span>';
			};

			if(Form.prototype.viewMode === 'html'){
				return 	'<div class="edit-field pull-right">' + 
					glyphicon(row, index, 'edit glyphicon-pencil') +
					glyphicon(row, index, 'clone glyphicon-duplicate') +
					glyphicon(row, index, 'delete glyphicon-trash') + '</div>';
			}
			
			return null;
		},
	
	sort: function(){

			var form = this,
				rowId = function (row){
		    			return row.substring(3); // row1 || row11 = 1 || 11
				};
			for (var i = this.body.length; i--;){
				var id = document.getElementById('row' + i);

				Sortable.create(id, {
					group: "row",
					animation: 0,
					ghostClass: "ghost",

					onAdd: function (e){
						var row = rowId(e.from.id),
							newRow = rowId(e.target.id),
							index = e.oldIndex,
							newIndex = e.newIndex,
							objToMove = form.body[row].splice(index, 1)[0]; // pobieramy obiekt ze starej lokalizacji i usuwamy

						form.body[newRow].splice(newIndex, 0, objToMove);	// wstawiamy obiekt na odpowiednie miejsce
						form.render();
					},

					onUpdate: function (e){
						var row = rowId(e.from.id),
							index = e.oldIndex,
							newIndex = e.newIndex;

						form.body[row].splice(newIndex, 0, form.body[row].splice(index, 1)[0]);
						form.render();
					}
				});
			}
		}
	};

return {
		Form: Form,
	}

})();
