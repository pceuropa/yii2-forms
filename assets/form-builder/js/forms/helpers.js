/**
* Helpers functions
* @author Rafal Marguzewicz
* @license MIT
*
* Functions:
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
    setAttribute
*/

"use strict";
console.log("helpers: 2.0.1");
var h = {

    /**
     * Capitalize First letter of string
     * @param {String} s
     * @return {String}
     */
capitalizeFirstLetter: function (s) {
        return s.charAt(0).toUpperCase() + s.slice(1);
    },

    /**
     * Removes empty viariables
     * @param {Object} object
     * @return {Object} return object without empty variables
     */
clearObject: function(o) {
        for (var i in o) {
            if (o[i] === null || o[i] === undefined) {
                delete o[i];
            }
        }
        return o;
    },

    /**
     * Clone object without reference
     * @param {Object} object
     * @return {Object} return clone object without reference
     */
clone: function (o) {
        var clone = {};

        for (var prop in o) {

            if( this.isArray(o[prop]) ) {
                for (var i = 0; i < o[prop].length; i++) {
                    clone[prop][i] = o[prop][i];
                }
            } else {
                clone[prop] = o[prop];
            }
        }
        return clone;
    },


    /**
     * iterator
     * @param {Array} object
     * @param {Function} object
     * @return {Object} return callaback function on each items
     */
each: function (arr, callback) {
        if(this.isArray(arr)) {
            var i = 0;
            for (i; i < arr.length; i++) {
                callback(i, arr[i]);
            }
        }
    },

    /**
     * Fibonacci numbers
     * @param {Integer} n
     * @param {Function} position of number Fibonacci Fn
     * @return {Object} return the sum of the sequence of numbers
     */
fibonacci: function (n) {
        return n < 1 ?  0 : n <= 2 ? 1 : this.fibonacci(n - 1) + this.fibonacci(n - 2);
    },

    /**
     * Return first property
     * @param {Object} n
     * @return {Object|false} return first property name or false if param o isnt object
     */
firstProp: function (o) {
        if(this.isObject(o)) {
            return Object.keys(o)[0];
        } else {
            return false
        }
    },

    /**
     * Return first value
     * @param {Object} n
     * @return {Object|false} return first value or false if param o isnt object
     */
firstValue: function (o) {
        if( this.isObject(o) ) {
            return o[Object.keys(o)[0]];
        } else {
            return false
        }
    },


    /**
     * Helpers for form.js
     * @see form.generate
     * @param {String} prop Name of property
     * @return {Array} return Array of values
     */
getAllProperty: function (prop, o) {
        var help = this, result = [];
        if(o.length == 0) return result;

        help.each(o, function (i, value) {
            if( value.length !== 0 || help.isArray(value)  ) {
                help.each(value, function (j, v) {

                    if ( v.hasOwnProperty(prop) ) {
                        result.push(v[prop])
                    }
                });
            }
        });

        return result;
    },

    /**
     * Is string
     * @param {Mixed} s
     * @return {Boolean} return True if param is string
     */
isString: function(s) {
        return typeof s === "string" || s instanceof String
    },

    /**
     * Is ?
     * @param {Mixed} v
     * @return {Boolean} return True if param have value
     */
is: function(v) {
        return (v !== null && v !== undefined && v !== '')
    },

    /**
     * Is boolean ?
     * @param {Mixed} v
     * @return {Boolean} return True if param is boolean
     */
isBoolean: function (v) {
        return typeof v === "boolean"
    },

    /**
     * Is Array
     * @param {Mixed} o
     * @return {Boolean} return True if param is array
     */
isArray: function (o) {
        if (!Array.isArray) {
            return Object.prototype.toString.call(o) === '[object Array]';
        } else {
            return Array.isArray(o);
        }
    },

    /**
     * Is object
     * @param {Mixed} o
     * @return {Boolean} return True if param is object
     */
isObject: function (o) {
        return typeof o === "object" && this.is(o);
    },

    /**
     * Inherit all property
     * @param {Object} o
     * @param {Object} inherit
     * @return {Void} return o
    */
inheritAll: function (o, inherit) {
        for (var prop in inherit) {
            if (inherit.hasOwnProperty(prop)) {
                o[prop] = inherit[prop];
            }
        }
    },

    /**
     * Replace all chars
     * @param {String} o
     * @param {String} char Default '_'
     * @return {String} return changed string
    */
replaceChars: function (o, char) {
        char = char || '_';
        return o.replace( new RegExp("\\W+", 'g'), char)
    },


    /**
     * Substring on sterid
     * @param {String} str
     * @param {Integer} len Length of string agter cut
     * @return {String} render select tag
    */
subString: function(str, len) {
        len = len || 10
              if(str.length > len) str = str.substring(0,len) + '...';
        return str
    },

/**
* Set attribute with chech is() 
* @param {String} attribute - name of attribute which will be add
* @param {String} value - value of attribute
* @returm {undefined}
*/
setAttribute: function(el, attribute, value) {
    if(   !this.isObject(el) || !this.isString(attribute) ) {
        return;
    }
    if (this.is(value)) {
        el.setAttribute(attribute, value) 
    }
},
    /**
    * Set attributes for field
    * @param {htmlElement} field
    * @param {Array} attributes - list attributes to check
    */
setAttributes: function(field, attributes) {
    if (!this.isArray(attributes)) {
        throw new TypeError("attributes must be array");
    }
        for (var i = 0, len = attributes.length; i < len; i++) {
            var attribute = attributes[i]

            if (this.isObject(attribute)) {
                this.setAttribute(field, this.firstProp(attribute), this.firstValue(attribute));
            }

            if (this.isString(attribute)) {
                this.setAttribute(field, attribute, this.body[attribute]);
            }
        } 
    },

    /**
    * Create field, set attributes and append
    * @param {String} param - name created Html element
    * @param {Array} listAttributes - list of attributes
    * @returm {HtmlElement}
    */
createElement: function(param, listAttributes) {
        var field = document.createElement(param);
        this.setAttributes(field, listAttributes);
        return field;
    },

    /**
     * Return unique Name
     * @param {String} name Attribute name of field tag
     * @param {Array} list of names
     * @return {String} render select tag
    */
uniqueName: function(name, list) {
        name = this.replaceChars(name)

        function changeName(n) {
            if (list.indexOf(n) !== -1) { //sprawdza n w liscie
                n = n + '_2'; //jezeli jest dodaje _2 i ponownie wykonuje siebie
                return changeName(n);
            } else {
                return n
            }
        }
        return changeName(name)
    },
};

