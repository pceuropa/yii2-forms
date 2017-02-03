"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
var h = {
		version: '1.0.1',
		isString: function(s) {
				return typeof s === "string" || s instanceof String
		},
		
		is: function(v) {
			return (v !== null && v !== undefined && v !== '')
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
		each: function (arr, callback) {
			var i = 0;
				for (i; i < arr.length; i++) {
					callback(i, value);
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
            
                $(el).on('keyup keypress paste', function(e){
                    
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


String.prototype.replaceAll = function(search, replacement) {
    return this.replace(new RegExp(search, 'g'), replacement);
};
