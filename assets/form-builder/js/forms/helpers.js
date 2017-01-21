"use strict";
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
var h = {
		isString: function(s) {
				return typeof myVar === s || s instanceof String
		},
		
		is: function(v) {
			return (v === null || v === undefined || v === '')
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
		}


	
};

String.prototype.replaceAll = function(search, replacement) {
    return this.replace(new RegExp(search, 'g'), replacement);
};
