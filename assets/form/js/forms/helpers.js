"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

/*
list of tools:
	capitalizeFirstLetter - capitalize first letter of string 
	clearObject - delete empty variable of object	
	clone - copy without reference
	
	each
	fibonacci	
	firstProp
	firstValue
	getName
	getAllProperty
	
	isString
	is
	isBoolean
	isArray
	isObject
	
	subString	
	setData	
	uniqueName	
*/





var h = {
		version: '2.0.1',
/**
 * Capitalize First letter of string 
 *
 * @param {String} s
 * @return {String}
 */	
		capitalizeFirstLetter: function (s) {
    		return s.charAt(0).toUpperCase() + s.slice(1);
		},
		
		
		clearObject: function(o){
		    for (var i in o) {
		        if (o[i] === null || o[i] === undefined) {
		            delete o[i];
		        }
		    }
		    return o;
		},
		
		clone: function (o) {
			var clone = {};

			for (var prop in o) {

					if( this.isArray(o[prop]) ){
						for (var i = 0; i < o[prop].length; i++){
							clone[prop][i] = o[prop][i];
						}
					} else {
						clone[prop] = o[prop];
					}
		    }
			return clone;
		},
		
		
		
		each: function (arr, callback) {
			if(this.isArray(arr)){
				var i = 0;
				for (i; i < arr.length; i++) {
					callback(i, arr[i]);
				}
			}
			
		},
		fibonacci: function (n) {
			   return n < 1 ?   0 : n <= 2 ? 1 : fibonacci(n - 1) + fibonacci(n - 2);
			},
		firstProp: function (o) {
			if(this.isObject(o)){
				return Object.keys(o)[0];
			} else {
				return false
			}
		},
		
		firstValue: function (o) {
			if( this.isObject(o) ){
				return o[Object.keys(o)[0]];
			} else {
				return false
			}
		},
		
		getName: function() { 
   			var 
   			funcNameRegex = /function (.{1,})\(/,
   			results = (funcNameRegex).exec((this).constructor.toString());
   		
   			return (results && results.length > 1) ? results[1] : "";
		},	

	
		getAllProperty: function (prop, o) {
			var help = this, result = [];
			if(o.length == 0 ) return result;
			
			help.each(o, function (i, value) {
				if( value.length !== 0 || help.isArray(value)  ){
					help.each(value, function (j, v) {
						
						if ( v.hasOwnProperty(prop) ) {
							result.push(v[prop])
						} 
					});
				}
				
			});
			
			return result;
		},
		
		isString: function(s) {
				return typeof s === "string" || s instanceof String
		},
		
		is: function(v) {
			return (v !== null && v !== undefined && v !== '')
		},
		
		isBoolean: function (v) {
			return typeof v === "boolean"
		},
		
		isArray: function (o) {
			if (!Array.isArray) {
				return Object.prototype.toString.call(o) === '[object Array]';
			} else {
				return Array.isArray(o);
			}
		},
		
		isObject: function (o) {
			return typeof o === "object" && this.is(o);
		},
		
		inheritAll: function (o, inherit) {
			for (var prop in inherit) {
				if (inherit.hasOwnProperty(prop)){
			        	o[prop] = inherit[prop];
				}
			}
		},
		
		replaceChars: function (o, char) {
			char = char || '_'
			return o.replace( new RegExp(/[^A-Za-z0-9w]/, 'g'), char)
		},
		
		renderSelectUpdateItem: function(field){
        	var helpers = this
		    if(field.body.hasOwnProperty('items')){
				if(field.body.items.length){
				
				        $("#" + field.body.field + " .select-item-to-change").html(
				            (function () {
				                var i = 0, text = '', itemOption = '';

				                for (i; i < field.body.items.length; i++) {
									text = field.body.items[i].text ? field.body.items[i].text : '';
									itemOption += '<option value="' + i + '">'+(i + 1) +'. ' + helpers.subString(text, 60) +'</option>';
								}
								return '<select class="change-item form-control input-sm"><option>Update</option>'+ itemOption + '</select>';  
				            })()
				        );
				} else {
					$("#" + field.body.field + " .select-item-to-change").empty()
				}
				
		    }	
		},
		
		subString: function(str, len) {
			len = len || 10
			if(str.length > len) str = str.substring(0,len) + '...';
			return str
		},
		
		setData: function (value) {  // set only not empty data
			return 
		},	
		setAttribute: function (el, attribute, value) {
			if(this.isObject(el) || this.isString(attribute) || this.is(value) ){
				el.setAttribute(attribute, value);
			}
		},
		
		
		
		uniqueName: function (name, list) {
			if( $.inArray(name, list) ){
		  		name = name + '_2'
		  	}
		  	return name;
		},
	
		
		
};

(function($){
    $.fn.extend({
        donetyping: function(callback, timeout){
            
            timeout = timeout || 1e3; // 1 second default timeout
            
            var timeoutReference,
                doneTyping = function(el){
                
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
                
            return this.each(function(i,el){
            
                $(el).on('keyup paste', function(e){
                    
                    if (timeoutReference) clearTimeout(timeoutReference); // stop timeout
                    
                    timeoutReference = setTimeout(function(){
                        doneTyping(el);
                    }, timeout);
                    
                }).on('blur',function(){
                    doneTyping(el);
                });
                
            });
            
            
        }
    });
})(jQuery);

