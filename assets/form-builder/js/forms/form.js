/**
* Create forms objects, render forms, and run controller(events) 
* https://pceuropa.net/yii2-extensions/yii2-forms/manual
* @author Rafal Marguzewicz
* @license MIT
* @constructor
* @return {Object} - public functions and FormModel
*/

"use strict";
console.log('form: 2.0.1');

var MyFORM = MyFORM || {};

MyFORM = (function() {
    var Form = function() {
        this.model =  {
            method: "post",
            language: "en",
            body: [],
        }
        this.time = 0;
        this.fields_with_data = [];
        this.c =  {
            get: false,
            save: true,
            autosave: false,
            controller_url: document.URL,
        }
    };

    Form.prototype = {
        constructor: Form,
        viewMode: 'html',           // to set use setter form.setView('text')
        time_out: 1,
        formElement: null,
        hide_form_options: false,  
        div_form: $("#preview-form"),
        options_form: $("#form"),
        map: { index: "0", row: "0" },
        // create get false, save true, autsave false
        // update get true, save true, autsave false/true

        init: function(config) {
            h.inheritAll(this.c, config) // form inherit all prop.value from config variable
            this.get();
            if (this.c.autosave) {
                this.autosaveButton();
                this.time_out = 800;
            }
            if (this.hide_form_options) {
              // TODO hide form options
            }
        },

        controller: function() {
            return MyFORM.controller(this);
        },

        autosaveButton: function() {
            $("#save-form").html('autosave mode').prop('disabled', true);
        },

        /**
        * Send request GET and response Json. Run generate() form. 
        * @return {undefined}
        */
        get: function() {
            var form = this;
            if (this.c.get) {
                $.getJSON(this.c.controller_url, function(r) {
                    console.log('upload from base correct');
                    form.generate(r)
                }).fail(function() {
                    console.log("error");
                });
            }
        },

        /**
        * Check number of asynchronous functions and run only last. Timeout 1sek.
        * @param {Function} callback - function to run
        * @return {undefined}
        */
        saveOnlyOneTime: function(callback) {
            if (this.time) clearTimeout(this.time)
            this.time = window.setTimeout(function() {
                callback()
            }, 1000)
        },

        /**
        * Save form
        * @return {undefined}
        */
        save: function() {
            var form = this,
                model = this.model,
                csrfToken = $('meta[name="csrf-token"]').attr("content"),
                data = {};
            if (!this.c.save) return false;

            for (var prop in model) {
                if (model.hasOwnProperty(prop)){
                  if (prop == 'body') {
                    data['body'] = JSON.stringify(model.body);
                  } else {
                    data[prop] = model[prop]
                  }
                }
            }

            $.post(form.c.controller_url, data, function(r) {

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
         * @param {String} old_name
         * @param {String} new_name
         */
        editTableName: function(options) {
            var old_name = options.old_name,
                new_name = options.new_name,
                success = options.success || function(){},
                error = options.error || function(){},
                form = this,
                csrfToken = $('meta[name="csrf-token"]').attr("content"),
                data = {};

            if (!h.is(new_name) || !h.is(old_name) || old_name === new_name || !this.c.autosave) return false

                data = {
                    change: { old: old_name, new: new_name },
                    _csrf: csrfToken
                };

                $.post(form.c.controller_url, data, function(r) {
                    if (r.success === true) {
                        success()  // callback function
                    } else {
                        error(r.success) // calback function
                    }
                });
            return true;
        },

        /**
        * Fill all form options inputs
        */
        setValueInputOptions: function() {
            this.options_form.find('#title').val(this.model.title);
            this.options_form.find('#url').val(this.model.url);
            this.options_form.find('#response').val(this.model.response);
        },

        /**
        * Callback message after write error
        * @param {String|Object} o - callback message from controller
        * @return {undefined}
        */
        errorSave: function(o) { // info 
            var save_form = $("#save-form"),
                clone = save_form.clone(),
                message_error = '';

            if (h.isString(o)) {
              message_error = o; 
            } else {
              message_error = h.firstValue(o);
            }

            save_form
                .addClass("btn-danger")
                .prop('disabled', true)
                .text(message_error);

            window.setTimeout(function() {
                save_form.replaceWith(clone);
            }, 3111);
        },


        /**
        * Callback message after success save
        * @return {undefined}
        */
        successSave: function() {
            var save_form = $("#save-form"),
                clone = save_form.clone();

            save_form
                .addClass("btn-success")
                .prop('disabled', true)
                .text('Saved form correctly');

            window.setTimeout(function() {
                save_form.replaceWith(clone);
            }, 1111);
        },

        /**
        * Filter pipeline 
        * @param {Object}  name - desc
        * @returm {Object}
        */
        filter: function(o) {
            var notReference = {}
            if(!h.is(o))  return false; 
            for (var prop in o) {
                if (o.hasOwnProperty(prop) && o[prop]) {

                    if (prop === 'name') {
                        o[prop] = h.uniqueName(o[prop], this.fields_with_data);
                    }

                    if (prop === 'items') {
                        o[prop].forEach(function(item, i) {
                            if (!h.is(o[prop][i].value)) o[prop][i].value = (i + 1);
                        })
                    }
                    notReference[prop] = o[prop];
                }

            }
            return notReference;
        },

        /**
        * Send data to backend 
        * @param {Object} o - field of form
        * @returm {undefined}
        */
        post: function(o) {
            if (this.c.autosave && o.hasOwnProperty('name')) {
                $.post(this.c.controller_url,
                    {add: o},
                    function(r) {
                        if (r.success === true) {
                            console.log('correct add');
                        } else {
                            console.log('Post: somting wrong: ' + r.success);
                        }
                    });
            }
        },
        
        /**
        * Add field to form
        * @param {Object} o - field of form
        * @returm {Boolean}
        */
        add: function(o) {
            try {
                if (o.hasOwnProperty('field')) {
                    var field = this.filter(o);

                    this.model.body.push([field]);
                    this.fields_with_data.push(field.name);
                    this.post(o);
                    this.render();

                    return true;
                } else {
                    return false;
                }
            } catch (err) {
                console.log(err);
                alert('Error add field to form: uncorrect  data')
            }
        },

        /**
        * Clone field and put after matrix
        * @param {int} row - row number
        * @param {int} index - position in row
        * @return {undefined}
        */
        cloneField: function(row, index) {
            var field = this.model.body[row][index],
                clone = jQuery.extend(true, {}, field); // clone with break reference/pointer data

            if (clone.hasOwnProperty('label')) {
                clone.label = field.label + '_2'
            }

            if (h.is(field.name)) {
                clone.name = h.uniqueName(field.name, this.fields_with_data);
                this.fields_with_data.push(clone.name);
            }

            this.model.body[row].splice(index + 1, 0, clone); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
            this.post(clone);
            this.render();
        },

        /**
        * Delete field
        * @param {int} row - row number
        * @param {int} index - position in row
        * @return {undefined}
        */
        deleteField: function(row, index) {
            var field = this.model.body[row][index];

            try {
                if (this.model.body[row].splice(index, 1)) {

                    if (this.c.autosave && this.c.save) {
                        $.post(this.c.controller_url, {
                            delete: field.name
                        }, function(r) {
                            if (r.success != true) {
                                console.log(r);
                            }
                        });
                    };
                    console.log('Delete item [', row, index, ']');
                    this.fields_with_data.splice(this.fields_with_data.indexOf(field.name), 1);
                    this.render();
                    return true;
                }  else {
                  return false;
                }
            } catch (err) {
                console.log('Item [', row, index, '] not exsist');
                return false;
            }
        },

        /**
        * Import data and call render()
        * @param {Object} o - form object
        * @return {undefined}
        */
        generate: function(o) {
            var result = false;

            if (h.isString(o.body)) {
                o.body = JSON.parse(o.body);
            }

            h.inheritAll(this.model, o);
            this.setValueInputOptions();
            this.fields_with_data = h.getAllProperty('name', this.model.body);
            if (this.model.body.length !== 0) this.render('off')
        },

        /**
        * List of modules. Can be expanded
        */
        modules: {
            init: function() {
            },
        },


        /**
        * Execute modules each render time
        */
        executeModules: function() {
            for (var prop in this.modules) {
                    this.modules[prop]();
            }
        },

        /**
        * Render form
        * @return {undefined}
        */
        render: function() {
            var form = this;

            switch (this.viewMode) {
                case 'html':
                    this.div_form.html(this.html());
                    this.sort(this);
                    break;
                case 'text':
                    this.div_form.html('<pre><button class="pull-right" id="copy-to-clipboard" data-clipboard-target="#text-code">Copy</button><code id="text-code"> </code></pre>').find('code').text(this.html());
                    break;
                case 'json':
                    this.div_form
                        .html('<pre><button class="pull-right" id="copy-to-clipboard" data-clipboard-target="#json-code">Copy</button><code id="json-code"> </code></pre>')
                        .find('code').text(JSON.stringify(this.model, null, 4));
                    break;
                case 'yii2':
                    this.div_form.html('<pre><code> </code></pre>').find('code').text('Yii2');
                    break;
                default:
                    throw "View mode error, check form.viewMode";
            }


            if (this.c.autosave && arguments[0] !== 'off') {
                this.saveOnlyOneTime(function() {
                    form.save()
                })
            }
            this.preventNotValidaData();
            this.executeModules();
        },

        // default save button if title or url are empty
        preventNotValidaData: function() {
            $("#save-form").prop('disabled', !(h.isString(this.model.title) && h.isString(this.model.url) && !this.c.autosave))
        },

        rows: function() {
            var rows = '',form = this;
            if (form.model.body.length == 0) return '';

            h.each(form.model.body, function(i) {
                form.formElement.appendChild(document.createTextNode("\n  "));
                form.formElement.appendChild(form.row(i));
                //rows += form.row(i)
            })
        },

        row: function(id) {
		    var div = document.createElement("div"), form = this;

                h.setAttribute(div, 'id', 'row'+ id);
                div.className = "row"

            form.model.body[id].forEach(function(item, i, array) {
                div.appendChild(document.createTextNode("\n\t"));
                div.appendChild( form.field(id, i));
                div.appendChild(document.createTextNode("\n\t"));
            })
            return div;
        },


        field: function(row, index) {
            var f = this.model.body[row][index],
            field = new MyFORM.field.factory(f);
            field =  field.html();
            if (this.viewMode == 'html') {
                field.appendChild(this.edit(row, index))
            }
            return field
        },

        edit: function(row, index) {
            var
              edit = h.createElement("span", [{"class": "glyphicon edit glyphicon-pencil"}, {"data-row": row}, {"data-index": index}, {"aria-hidden": "true"}]),
              clone = h.createElement("span", [{"class": "glyphicon clone glyphicon-duplicate"}, {"data-row": row}, {"data-index": index}, {"aria-hidden": "true"}]),
              del= h.createElement("span", [{"class": "glyphicon delete glyphicon-trash"}, {"data-row": row}, {"data-index": index}, {"aria-hidden": "true"}]),
              div = h.createElement("div", [{"class": "edit-field pull-right"}]);
            div.appendChild(edit);
            div.appendChild(clone);
            div.appendChild(del);
            return div;
        },

        html: function() {
		     this.formElement = document.createElement("form");

                h.setAttribute(this.formElement, "action", this.model.action);
                h.setAttribute(this.formElement, "method", this.model.method);
                h.setAttribute(this.formElement, "id", this.model.id);
                h.setAttribute(this.formElement, "class", this.model.class);
                this.rows();
                this.formElement.appendChild(document.createTextNode("\n"));

            return this.formElement.outerHTML;
        },

        // set view mode (html|text|json|Yii2) use in controller.js
        setView: function(view) {
            this.viewMode = view || '';
        },



        sort: function() {

            var form = this,
                rowId = function(row) {
                    return row.substring(3); // row1 || row11 = 1 || 11
                };
            for (var i = this.model.body.length; i--;) {
                var id = document.getElementById('row' + i);

                Sortable.create(id, {
                    group: "row",
                    animation: 0,
                    ghostClass: "ghost",

                    onAdd: function(e) {
                        var row = rowId(e.from.id),
                            newRow = rowId(e.target.id),
                            index = e.oldIndex,
                            newIndex = e.newIndex,
                            objToMove = form.model.body[row].splice(index, 1)[0]; // pobieramy obiekt ze starej lokalizacji i usuwamy

                        form.model.body[newRow].splice(newIndex, 0, objToMove); // wstawiamy obiekt na odpowiednie miejsce
                        form.render();
                    },

                    onUpdate: function(e) {
                        var row = rowId(e.from.id),
                            index = e.oldIndex,
                            newIndex = e.newIndex;

                        form.model.body[row].splice(newIndex, 0, form.model.body[row].splice(index, 1)[0]);
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
