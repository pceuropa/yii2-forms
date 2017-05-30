/*
 * https://pceuropa.net/yii2-extensions/yii2-forms/manual
 * Licensed MIT © 2016-2017 Rafal Marguzewicz
 */
"use strict";


var MyFORM = MyFORM || {};
MyFORM = (function() {
    console.log('form: 1.6.0');
    var fields_with_data = [], // array for false autosave
    t = 0,

        Form = function() {
            //this.url = null;
            //this.action = "";
            this.method = "post";
            this.language = "en";
            this.body = [];
        };

    Form.prototype = {
        // filter after save
        hello: 'hello Vege',
        constructor: Form,
        viewMode: 'text',
        time_out: 1,
        hide_form_options: false,  
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

        init: function(config) {

            h.inheritAll(this.c, config) // form inherit all prop.value from config variable
            this.get();
$('#view-mode').val('text');
            if (this.c.autosave) {
                this.autosaveButton();
                Form.prototype.time_out = 800;
            }
            if (this.hide_form_options) {
              
            }
        },

        controller: function() {
            return MyFORM.controller(this, new MyFORM.field.factory());
        },

        autosaveButton: function() {
            $("#save-form").html('autosave mode').prop('disabled', true);
        },


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


        saveOnlyOneTime: function(callback) {
            if (t) clearTimeout(t)
            t = window.setTimeout(function() {
                callback()
            }, 1000)
        },


        save: function() {
            var form = this,
                csrfToken = $('meta[name="csrf-token"]').attr("content"),
                data = {};

            if (!this.c.save) return false;

            for (var prop in form) {
                if (form.hasOwnProperty(prop)){
                  if (prop == 'body') {
                    data['body'] = JSON.stringify(form.body);
                  } else {
                  data[prop] = form[prop]
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
         *
         * @param {String} old_name
         * @param {String} new_name
         */
        editTableName: function(options) {
            var old_name = options.old_name,
                new_name = options.new_name,
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
                        options.success()  // callback function
                    } else {
                        options.error(r.success) // calback function
                    }
                });
           return true;
        },


        setValueInputOptions: function() {
            this.options_form.find('#title').val(this.title);
            this.options_form.find('#url').val(this.url);
            this.options_form.find('#response').val(this.response);
        },


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
                        o[prop] = h.uniqueName(o[prop], fields_with_data);
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
        * Send data to backend controller
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
                            console.log(r.success);
                            alert('Somting wrong: ' + r.success);
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
                    this.body.push([field]);
                    fields_with_data.push(field.name);
                    this.post(o);
                    this.render();
                    return true;
                } else {
                    return false;
                }
            } catch (err) {
                console.log(err);
                alert('Error add field to form: bad data')
                return false;
            }
        },

        /**
        * Clone field and put after matrix
        * @param {int} row - row number
        * @param {int} index - position in row
        * @return {undefined}
        */
        cloneField: function(row, index) {

            var first = this.body[row][index],
                o = jQuery.extend(true, {}, first); // clone with break reference/pointer data

            if (o.hasOwnProperty('label')) {
                o.label = first.label + '_2'
            }

            if (h.is(first.name)) {
                o.name = h.uniqueName(o.name, fields_with_data);
                fields_with_data.push(o.name);
            }

            this.body[row].splice(index + 1, 0, o); // wstawiamy obiekt na odpowiednie miejsce bez usuwania
            this.post(o);
            this.render();

        },

        /**
        * Delete field
        * @param {int} row - row number
        * @param {int} index - position in row
        * @return {undefined}
        */
        deleteField: function(row, index) {

            var field = this.body[row][index];

            try {
                if (this.body[row].splice(index, 1)) {

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
                    this.render();
                }

            } catch (err) {
                console.log('Item [', row, index, '] not exsist');
            }
        },

        /**
        * Import data and call render()
        * @param {Object} o - form object
        * @return {undefined}
        */
        generate: function(o) {
            var result = false;
            o.body = JSON.parse(o.body);
            h.inheritAll(this, o);
            this.setValueInputOptions();
            fields_with_data = h.getAllProperty('name', this.body);
            if (this.body.length !== 0) this.render('off')
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

            switch (Form.prototype.viewMode) {
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
                        .find('code').text(JSON.stringify(this, null, 4));
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
            $("#save-form").prop('disabled', !(h.isString(this.title) && h.isString(this.url) && !this.c.autosave))
        },

        attr: function() {
            var i, temp = '',
                max = arguments.length;

            for (var i = 0; i < max; i += 1) {
                temp += this[arguments[i] + 'Attr']();
            }
            return temp;
        },

        idAttr: function() {
            return this.id ? ' id="' + this.id + '"' : '';
        },

        classAttr: function() {
            return this['class'] ? ' class=" ' + this['class'] + '"' : ' class=""';
        },

        // rows -> row - > fields - > field - > render
        rows: function() {
            var rows = '',
                form = this;
            if (form.body.length == 0) return '';

            h.each(form.body, function(i) {
                rows += form.row(i)
            })
            return rows;
        },

        row: function(id) {
            return '\n<div id="row' + id + '" class="row">\n' + this.fields(id) + ' \n</div>\n';
        },
        fields: function(id) {
            var fields = '',
                form = this;
            this.body[id].forEach(function(item, i, array) {
                fields += form.field(id, i);
            })


            return fields;
        },

        field: function(row, index) {
            var f = this.body[row][index],
                field = new MyFORM.field.factory(f);

            // test ----- console.log(row, index, f.field, Array(20 - f.field.length).join("-"), field);

            if (Form.prototype.viewMode === 'html') {
                field.divEnd = function() {
                    return Form.prototype.edit(row, index) + '\n</div>\n';
                }
            }

            return field.html();
        },



        html: function() {
            return '<form  action="' + this.action + '" method="' + this.method + '" ' + this.attr('id', 'class') + '>' +
                this.rows() + '\n</form>';
        },

        // set view mode (html|text|json|Yii2) use in controller.js
        setView: function(view) {
            Form.prototype.viewMode = view || '';
        },


        edit: function(row, index) {
            function glyphicon(row, index, cl) {
                return '<span class="glyphicon ' + cl + '" data-row="' + row + '" data-index="' + index + '" aria-hidden="true"></span>';
            };

            if (Form.prototype.viewMode === 'html') {
                return '<div class="edit-field pull-right">' +
                    glyphicon(row, index, 'edit glyphicon-pencil') +
                    glyphicon(row, index, 'clone glyphicon-duplicate') +
                    glyphicon(row, index, 'delete glyphicon-trash') + '</div>';
            }

            return null;
        },

        sort: function() {

            var form = this,
                rowId = function(row) {
                    return row.substring(3); // row1 || row11 = 1 || 11
                };
            for (var i = this.body.length; i--;) {
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
                            objToMove = form.body[row].splice(index, 1)[0]; // pobieramy obiekt ze starej lokalizacji i usuwamy

                        form.body[newRow].splice(newIndex, 0, objToMove); // wstawiamy obiekt na odpowiednie miejsce
                        form.render();
                    },

                    onUpdate: function(e) {
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
