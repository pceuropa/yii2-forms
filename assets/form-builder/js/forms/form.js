"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

var MyFORM =  MyFORM || {};
MyFORM = (function(){
console.log('form');

	var hello = 'hello Vege',
		version = '1.0.0',
	
	Form = function (){
		this.title =  "FormBuilder";
		this.action = "";
		this.method = "post";
		this.language = "English"; 
		this.body = [];
	};

	Form.prototype = {
		// filter after save

		questionsNames: [],
		constructor: Form,
		viewMode: 'html',
		map: { index: "0", row: "0" },
		config: {
			get: false, 
			save: true, 
			autosave: false, 
			create_url: document.URL, 
			update_url: document.URL
		},
	// create get false, save true, autsave false
	// update get true, save true, autsave false/true
	
	init: function (config) {
		
		this.config = config || this.config;
		this.get();
	
		return MyFORM.controller(this, new MyFORM.field.factory());
		
	},
    clear: function (o) {
        var notReference = {} 
        for (var prop in o) {
            if (o.hasOwnProperty(prop) && o[prop]){
            	
		        if(prop === 'name'){
		        	o[prop] = this.filter(o[prop]);
		        }
		        
		        if(prop === 'items'){
				    for (var i = 0; i < o[prop].length; i++) {
						if(o[prop][i].value === ''){
		    	        		o[prop][i].value = (i + 1);
		    	        	}
			    	}
	        	}
	        	
	        	notReference[prop] = o[prop];
	        }
            
        }
        return notReference;
    },
	filter: function (o){
		var questions = this.questionsNames;
	  	o = o.replace( new RegExp(/\W/, 'g') , '_');
	  	
		for (var prop in questions) {
			if(questions[prop] === o){
				o = o + '_2'
			}
		}
		questions.push(o);
	
		return o;
	},
	scenerio: function () {
		return this.config.save && this.config.autosave;
	},
	get: function (){
			var form = this;
			if(this.config.get){
				$.getJSON(document.URL, function(r){
					console.log('upload from base correct');
					form.generate(r)
				});
			}
		},
	
	
	save: function (){
			var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			
			if(this.config.save){
				data = {request_data: JSON.stringify(form), _csrf : csrfToken };

				$.post( document.URL, data, function (r){
					if (r.success === true) { 
						console.log('save from base correct');
						form.operations++; 
						form.afterSuccessSave();
						if (r.url){ window.location.href = r.url;}
					}
				});
			}
	},
	
	editName: function(old_name, new_name){
		var form = this, csrfToken = $('meta[name="csrf-token"]').attr("content"), data = {};
			console.log(this.config.save);
			
			if(this.config.save){
				data = {change_name: {old: old_name, new: new_name}, _csrf : csrfToken };

				$.post( document.URL, data, function (r){
					if (r.success === true) { 
						console.log('new name change correct');
					}
				});
			}
	},
	
	
	postData: function () {
		return null
	},
	
	afterSuccessSave: function () {
		window.setTimeout(function() {
		  	$( "#save-form" ).addClass( "btn-success" ).prop('disabled', true ).text('Saved form correctly');
		  }, 111)
		
		window.setTimeout(function() {
		  	$( "#save-form" ).removeClass( "btn-success" ).prop('disabled', false ).text('Save form');
		  }, 1111)
	},
		
	add: function (o){
			try {
				if (o.hasOwnProperty('field') ){
			
					this.body.push([this.clear(o)]);
				
					if (o.hasOwnProperty('name')){
						$.post( document.URL, {add: o} );
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
	
			var first = this.body[row][index], 
				o = jQuery.extend(true, {}, first); ;
			
			if (o.hasOwnProperty('label')){
				o.label = first.label + '_2'
			} 
			o.name = first.name + '_2'
			
			this.body[row].splice(index + 1, 0, o); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
			this.render();
			
			if(this.config.autosave){
				this.save();
				
				if (o.hasOwnProperty('name')){
						$.post( document.URL, {add_field: o} );
					} 
			}
			
	},
 
	deleteField: function(row, index){
		var field = this.body[row][index]
		
			try {
				if(this.body[row].splice(index, 1)){
					console.log('Delete item [', row , index, ']');
					this.render();
					
					if(this.config.autosave && this.config.save){
						$.ajax({
						  url: document.URL,
						  type: 'post',
						  dataType:'JSON',
						  data: {delete: field.name},
						  success: function (r) {
									if (r.success === false) {console.log(r);}
									if (r.success === true) {console.log(r);}
								},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert(textStatus);
							}
						});
					}
				}
			}
			catch(err){
				console.log('Item [', row , index, '] not exsist');
				
			}
			
			if(this.config.autosave){
				this.save();
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
			
			if(this.config.autosave){
				this.save();
			}
		
		},

    // depraced
	deleteItem: function (row, index, id){
			this.body[row][index]['items'].splice(id, 1);
			this.render();
		},

	generate: function(o){
 	
			this.title = o.title || '';;
			this.action = o.action || '';
			this.method = o.method || '';
			this.id = o.id || '';
			this.body['class'] = o['class'] || '';
			this.body = o.body || {};
		    if(this.body.length > 0){
		    	this.render();
		    }
		},





// <---- View

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
			if(form.body.length == 0) return;
			
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
	render: function(){
			var divForm = $("#preview-form");
			
			switch(Form.prototype.viewMode){
			    case 'text': divForm.html('<pre><code> </code></pre>').find('code').text(this.view('html')); break;
				case 'json': divForm.html('<pre><code> </code></pre>').find('code').text(this.view('json')); break;
				case 'yii2': divForm.html('<pre><code> </code></pre>').find('code').text('Yii2'); break;
			    default: 	 divForm.html(this.view('html')); this.sort(this); break;
			}
			
		
			
			
	},

	view: function (mode){
			 switch(mode){
				case 'html': 
					return '<form  action="' + this.action + '" method="' + this.method + '" ' + this.attr('id', 'class') + '>' +
							this.rows() + '\n</form>';; break;
				case 'json': return JSON.stringify(this, null, 4); break;
				case 'h1': return this.title; break;
				default: null;
			} 

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
		version: version,
		Form: Form,
	}

})();
