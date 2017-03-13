/*
 * https://pceuropa.net/yii2-extensions/yii2-forms/manual
 * Licensed MIT © 2016-2017 Rafal Marguzewicz
 */
 "use strict";


var MyFORM =  MyFORM || {};
MyFORM = (function(){
console.log('form: 1.3.0');
var fields_with_data = [], // array for false autosave
	Form = function (){

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
		constructor: Form,
		viewMode: 'html',
		time_out: 1,
		t: null,
		tn: null,
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
		
		h.inheritAll(this.c, config)  // form inherit all prop.value from config variable
		this.get();
		if(this.c.autosave){
			this.autosaveButton();
			Form.prototype.time_out = 800;
		}
		return MyFORM.controller(this, new MyFORM.field.factory() );
		
	},
	
	autosaveButton: function () {
		$("#save-form").html('autosave mode').prop('disabled', true);
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
	
	
	saveOnlyOneTime: function (callback, stopPropagation) {
		var form = this
		if (this.t) clearTimeout(this.t)
			this.t = window.setTimeout(function() { callback()  }, 1000)
	},
	
	
	save: function (){
			var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			
			if(!this.c.save) return false;
			
			data = {form_data: JSON.stringify(form), title: form.title, url: form.url,  _csrf : csrfToken };

				$.post( form.c.controller_url, data, function (r){
				
					if (r.success === true) { 
						console.log('save in base correct');
						form.successSave();
						if (r.url){ window.location.href = r.url;}
					} else {
						form.errorSave(r.success);
					} 
				})
	},
	
/**
 * Send ajax request to controller change sql table name
 *
 * @param {String} old_name
 * @param {String} new_name
 */
	editTableName: function(options){
		var old_name = options.old_name,
			new_name = options.new_name
	
		if( !h.is(new_name) && !h.is(old_name) && old_name === new_name) return false
			
		var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			
				if(form.c.autosave){
				data = {change: {old: old_name, new: new_name}, _csrf : csrfToken };
				
					$.post(form.c.controller_url, data, function (r){
					if (r.success === true) { 
						options.success()
					} else {
						options.error(r.success)
					}
				});
			}
	},
	
	
	setValueInputOptions: function() {
		this.options_form.find('#title').val(this.title);
		this.options_form.find('#url').val(this.url);
		this.options_form.find('#response').val(this.response);
	},
	
	
	errorSave: function(o) {   // info 
		var save_form = $( "#save-form" ), clone = save_form.clone();
		
		
		
		save_form
			.addClass("btn-danger" )
			.prop('disabled', true )
			.text(h.firstValue(o));
		
		window.setTimeout(function() { save_form.replaceWith(clone); }, 3111);
	
	},
	
	successSave: function() {
		
		var save_form = $( "#save-form" ), clone = save_form.clone();
		
		save_form
			.addClass("btn-success" )
			.prop('disabled', true )
			.text('Saved form correctly');
		
		window.setTimeout(function() { save_form.replaceWith(clone); }, 1111);
		
		
	},

/**
 * Add field object to form object
 *
 * @param {Object} o
 */
 	clear: function (o) {
        var notReference = {} 
        
        for (var prop in o) {
            if (o.hasOwnProperty(prop) && o[prop]){
            	
		        if(prop === 'name'){
		        	o[prop] = this.uniqueName( o[prop] );
		        	console.log('o[prop]', o[prop]);
		        	
		        }
		        
		        if(prop === 'items'){
		        	o[prop].forEach(function(item, i){
							if( !h.is(o[prop][i].value) ) o[prop][i].value = (i + 1);
		        	    })
		        	    
	        	}
	        	
	        	notReference[prop] = o[prop];
	        }
            
        }
        return notReference;
    },
    
 	 uniqueName: function (name){
    	name = h.replaceChars(name)
    	
    	function changeName(n) {
    		if($.inArray(n, fields_with_data) !== -1){ 	//sprawdza n w liscie
    			n = n + '_2'; //jezeli jest dodaje _2 i ponownie wykonuje siebie
    			return changeName(n);
    		} else {
    			return n
    		}
    	}
	  	
	  	name = changeName(name)
	  	
		fields_with_data.push(name);
		return name;
	},
	post: function (o) {
		if (this.c.autosave && o.hasOwnProperty('name')){
			$.post( this.c.controller_url, {add: o}, function (r) {
				if(r.success.success === true){
					console.log('correct add');
				} else {
					console.log(r.success.success);
					
					alert('Somting wrong: '+ r.success);
				}
				
			});
		} 
	},
		
	add: function(o){
			try {
				if (o.hasOwnProperty('field') ){
			
					this.body.push([this.clear(o)]);
					this.post(o);
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
				o = jQuery.extend(true, {}, first);   // clone with break reference/pointer data
				
			if (o.hasOwnProperty('label')){
				o.label = first.label + '_2'
			} 
			
			if(h.is(first.name)){
				o.name = this.uniqueName(o.name);
			}
			this.body[row].splice(index + 1, 0, o); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
			this.post(o);
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

/**
 * Import data and render
 *
 * @param {Object} o
 */
 
	generate: function(o){
 			h.inheritAll(this, o);
		    if(this.body.length !== 0) this.render('off')
		    
		    this.setValueInputOptions();
			fields_with_data = h.getAllProperty('name', this.body);
			console.log(fields_with_data);
			
		},


/**
 * Render form
 */
	render: function(){
		var form = this;
	
			switch(Form.prototype.viewMode){
				case 'html': this.div_form.html(this.html()); this.sort(this); break;
			    case 'text': this.div_form.html('<pre><code class="language-html"> </code></pre>').find('code').text(this.html()); break;
				case 'json': this.div_form.html('<pre><button class="pull-right" id="copy-json" data-clipboard-target="#json-code">Copy</button><code id="json-code"> </code></pre>').find('code').text(JSON.stringify(this, null, 4)); break;
				case 'yii2': this.div_form.html('<pre><code> </code></pre>').find('code').text('Yii2'); break;
			    default: 	throw "View mode error, check form.viewMode";
			}
			
			
			if(this.c.autosave && arguments[0] !== 'off' ){
				this.saveOnlyOneTime(function () {
					form.save()
				})
			}
			this.preventNotValidaData();
			
	},
	// default save button if title or url are empty
	preventNotValidaData: function () { 
		$("#save-form").prop('disabled', !( h.isString(this.title) && h.isString(this.url) &&  !this.c.autosave) )
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
		    var fields = '', form = this;
		    this.body[id].forEach(function (item, i, array) {
		    	fields += form.field(id, i);
		    })
		    
		    
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
