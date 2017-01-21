"use strict";
//#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net

var MyFORM =  MyFORM || {};
MyFORM = (function(){

	var hello = 'hello',
		version = '1.0',
	
	Form = function (){
		this.title =  "FormBuilder";
		this.action = "";
		this.method = "post";
		this.language = "English"; 
		this.body = [];
		this.get();
		console.log('constructor');
		this.render()
		
	};


	Form.prototype = {


		constructor: Form,
		viewMode: 'html',
		map: { index: "0", row: "0" },
		config: {get: true, save: true, autosave: false},

	
    clear: function (o) {
        var notReference = {}
        for (var prop in o) {
            if (o.hasOwnProperty(prop)){
                    notReference[prop] = o[prop];
            }
        }
        return notReference;
    },
	filter: function (o){
		var clear = {};
		for (var prop in o){
				if (o[prop]){
					if(Array.isArray(o[prop])){
							clear[prop] = [];
							for (var i = o[prop].length; i--;){
            					clear[prop][i] = o[prop][i];
								
							}
							o[prop] = [];
					} else {
						if(prop !== 'view'){
							clear[prop] = o[prop];
						}
					}
				}
		    }
		return clear;
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

	
	// rows -> row - > fields - > field - > render

	rows: function(){
		    var rows = '';
			if(this.body.length == 0) return rows;
		    for (var i = 0, max = this.body.length; i < max; i += 1){
		        rows += this.row(i);
		    }
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

			
		return field.html();
		},
	render: function(){
			var divForm = $("#preview-form");
			console.log('text');
			
			switch(Form.prototype.viewMode){
			    case 'text': divForm.html('<pre><code> </code></pre>').find('code').text(this.view('html')); break;
				case 'json': divForm.html('<pre><code> </code></pre>').find('code').text(this.view('json')); break;
				case 'yii2': divForm.html('<pre><code> </code></pre>').find('code').text('Yii2'); break;
			    default: 	 divForm.html(this.view('html')); break;
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

		


	setView: function(view){
			Form.prototype.viewMode = view || '';
		},
	


	

	};

return {
		version: version,
		Form: Form,
	}

})();
