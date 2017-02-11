"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
var h = {
		version: '1.2.0',
		
		isString: function(s) {
				return typeof s === "string" || s instanceof String
		},
		
		is: function(v) {
			return (v !== null && v !== undefined && v !== '')
		},
		
		
		isArray: function (o) {
			if (!Array.isArray) {
				return Object.prototype.toString.call(o) === '[object Array]';
			} else {
				return Array.isArray(o);
			}
		},
		
		isObject: function (o) {
			return typeof o === "object";
		},
		
		clearObj: function(o){
		    for (var i in o) {
		        if (o[i] === null || o[i] === undefined) {
		            delete o[i];
		        }
		    }
		    return o;
		},
		fibonacci: function (n) {
			   return n < 1 ?   0 : n <= 2 ? 1 : fibonacci(n - 1) + fibonacci(n - 2);
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
		firstProp: function (o) {
			return Object.keys(o)[0];
		},
		
		firstValue: function (o) {
			return o[Object.keys(o)[0]];
		},
		
		
		replaceSpaces: function (o) {
			return o.replace( new RegExp(/\W/, 'g'), '_')
		},
		inheritAll: function (o, inherit) {
			for (var prop in inherit) {
				if (inherit.hasOwnProperty(prop)){
			        	o[prop] = inherit[prop];
				}
			}
		},
		each: function (arr, callback) {
			if(this.isArray(arr)){
				var i = 0;
				for (i; i < arr.length; i++) {
					callback(i, arr[i]);
				}
			}
			
			},
			
		setAttribute: function (el, attribute, value) {
			if(this.isObject(el) || this.isString(attribute) || this.is(value) ){
				el.setAttribute(attribute, value);
			}
		},
		
		clone: function (o) {
			var clone = {};

			for (var prop in o) {
				if (clone[prop]){
					if(Array.isArray(o[prop])){
						for (var i=0; i < o[prop].length; i++){
							clone[prop][i] = o[prop][i];
						}
					} else {
						clone[prop] = o[prop];
					}
				}
		    }
			return clone;
		},
		
		uniqueName: function (name, list) {
			if( $.inArray(name, list) ){
		  		name = name + '_2'
		  	}
		  	return name;
		},
		
		getName: function() { 
   			var 
   			funcNameRegex = /function (.{1,})\(/,
   			results = (funcNameRegex).exec((this).constructor.toString());
   		
   			return (results && results.length > 1) ? results[1] : "";
		},
		capitalizeFirstLetter: function (s) {
    		return s.charAt(0).toUpperCase() + s.slice(1);
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

