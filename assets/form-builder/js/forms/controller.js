'use strict';
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

var MyFORM =  MyFORM || {};
MyFORM.controller = function(form){
	
var version = '2.0.1',
  field = {},
    key_item_change = 0,
    update_mode = false,				// selectItemToChange()
    preview_form = form.div_form,
    preview_field = $('#preview-field'),
    field_selector,
    sidebar = $('#sidebar'),
    sidebar_div_options = $('#sidebar div.options'),
    options_form = form.options_form,
    
    select_field = $('#select-field'),

    form_tab =		$('#form-tab'),     // form options tab
    field_tab = 	$('#field-tab'),    // field options tab
    udpate_tab =	$('#update-tab'),   // update options tab
    delete_tab =	$('#delete-tab'),   // delete field tab
    
    update_div = $('#update'),
    delete_div = $('#delete');
    
    console.log('controller:', version);

var quill = new Quill('#textdescription', {
    theme: 'snow',
       modules: {
        'toolbar': [
          [{ 'header': [1, 2, false] }],
          [ 'bold', 'italic',],
          [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'align': [] }],
          ['link'],
          ['clean']
        ],
      },
  });



    /**
    * Events - triger by click on form html elements
    * @return {undefined}
    */
    preview_form
        .on('click',	'.edit', 	 function(e){ updateField(e)  })
        .on('click',	'.clone', 	 function(e){ cloneField(e) })
        .on('click',	'.delete', 	 function(e){ deleteField(e)   })
        .on('click',	'button', 	 function(e){
            var button = $(this), clone = button.clone();
            e.preventDefault(); 

            button.text('edit mode');
            window.setTimeout(function() {button.replaceWith(clone);}, 1111)
    });
    
   /**
    * Change view mode (text, html, json, Yii2-beta)
    * @return {undefined}
   */
    $('#view-mode').change(function (){
        form.setView(this.value);
        form.render('off');
        var clipboard = new Clipboard('#copy-to-clipboard');

        clipboard.on('success', function(e) {
            $('#copy-to-clipboard').text('Copied!').fadeOut().fadeIn(100, function () {
                $('#copy-to-clipboard').text('Copy')
            });
        });

        clipboard.on('error', function(e) { console.log(e) });
    })

    sidebar_div_options
        .on('click',    '#add-to-form',         function(e){ addField(e) })
        .on('click',    '.add-item',            function() { addItem() }) 
        .on('change',   '.change-item',   		function(e){ updateItem(e)})   
        .on('click',    '.clone-item-field',    function(e){ cloneItem(); $('.input-item input').unbind() })    
        .on('click',    '.delete-item-field',   function(e){ deleteItem(); $('.input-item input').unbind() })

        .on('click',    '.back',    			function(e){ back(e); $('.input-item input').unbind() }) 
        .on('mouseenter','#prevent-empty-name', function(e){ preventEmptyName(e) })
        .on('mouseenter','#widget-form-options',function(e){ preventEmptyTitleUrl(e) })

    $('#sidebar')
        .on('click',    '#form-tab',            function(e){ activeTab(e.target); activeAction('#form') })   
        .on('click',    '#field-tab',           function(e){ activeTab(e.target); select_field.change() })   
        .on('click', 	'#save-form',           function() { form.save() })  

    
    /**
    * Event (change) on select (dropdown) Every change field set field to edit
    * @return {undefined}
    */
    select_field.change(function () {
        field_selector = $('#' + this.value);
		select_field.addClass('show');
		activeAction(field_selector);
		
		window.scrollTo(0, document.body.scrollHeight - 50);
		
		field_selector.find('.input-item').removeClass( "update" );
		
		field = new MyFORM.field.factory({field: this.value});
        field.setDefaultValuesInputs("data-source");
		field.setDataFieldFrom("data-source")  // class
		field.render();
	});
    /**
    * Add field to form
    * @param {event} e - event data object
    * @returm {undefined}
    */
    function addField (e) {
        form.add(field.body);
        $(e.delegateTarget).find("#name").val('');
        $(e.delegateTarget).find("#add-to-form").prop('disabled', true);
    }

   /**
   * Test canvas
   * @param {HTMLElement} div 
   */ 
   function loadCanvas(div) {
        var canvas = document.createElement('canvas');

        canvas.id     = "CursorLayer";
        canvas.width  = 500;
        canvas.height = 2;
        canvas.style.zIndex   = 8;
        canvas.style.position = "absolute";
        line(canvas)
        div.appendChild(canvas)
    } 
    
    /**
    * Action edit field
    * @param {event} e - click on update buton
    * @return {undefined}
    */
    function updateField(e){
		var field_selector, map = e.target.dataset, id = 0,
            element = e.currentTarget.parentElement.parentElement;

		sidebar.addClass( "update" );
        element.classList.add("update-field");


        $('.input-item').removeClass( "update" );
        $('.item-of-field').val( null );

        field.body = form.model.body[map.row][map.index];
        console.log(field.body);
        
        field_selector = $("#" + field.body.field)
        
        activeTab('#update-tab');
		activeAction(field_selector);
			
			if(field.body.field != 'description'){
				for (var prop in field.body) {
            
					if (field.body.hasOwnProperty(prop) && prop !== 'field'){
					
						if(typeof field.body[prop] === 'string'){
							field_selector.find('#' + prop).val(field.body[prop]);
						}

						if(typeof field.body[prop] === 'boolean'){
							field_selector.find('#' + prop).prop('checked', field.body[prop]);
						}
					} 
				}
			} else {
				document.getElementById('textdescription').firstChild.innerHTML = field.body.textdescription
				//field_selector.find("#textdescription").first().html(field.body.textdescription)
				//editor.content = 
			}
			
		renderSelectUpdateItem(field)	
			// $('#update span').find('input, textarea, select').on('keyup change', function (){});
	}

    /**
    * Clone field
    * @param {event} e - click on clone buton
    * @return {undefined}
    */
	function cloneField(e){
		var map = e.target.dataset;	
			form.cloneField(map.row, map.index);
	}

    /**
    * Delete field of form
    * @param {event} e - click on update buton
    * @return {undefined}
    */
	function deleteField(e){
		var map = e.target.dataset, element = e.currentTarget.parentElement.parentElement;


			activeTab(delete_tab);
			activeAction('#delete');

        element.classList.add("delete-field");

		$('button#btn-delete-confirm').unbind().click(function () {
			form.deleteField(map.row, map.index);
			form.render();
			field_tab.click();
			
		});	
	}
    

    
   /**
   * Add item to field (radio|checkbox|select)
   * @return {undefined}
   */
    function addItem(){
        var o = field.setDataItemFrom('item-of-field'); // class
        field.addItem(field, o);
        render();
    }

   /**
   * Select item of field to update
   * @param {Event} e - help to chose element delegate
   * @return {undefined}
   */
    function updateItem(e){ // select item to change
        var item = field.body.items[e.currentTarget.value],
        	el = $(e.delegateTarget).find('.input-item');
        
        	key_item_change = e.currentTarget.value;
        	console.log(key_item_change);
        	
        	toggleButtonsUpdateItem();
        
        for (var prop in item) {
            
            (h.isBoolean( item[prop]) ) ?
            	el.find('input#' + prop).prop('checked', item[prop]) :
            	el.find('input#' + prop).val(item[prop]);
        }

        $(e.delegateTarget).find('.input-item input').on('keyup change', 
	        function() {
		        item[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
                if (!item.checked) {
                    delete item.checked
                }
                console.log(item);
		        render();
	        }
        );
    }
    /**
    * Clone item of field
    * @param {Event} e - 
    * @return {undefined}
    */
    function cloneItem(){
        var o = form.filter(field.body.items[key_item_change]);
        o.value = field.body.items.length + 1
        field.body.items.push(o)
        toggleButtonsUpdateItem();
    }

    function deleteItem(){
        field.body.items.splice(key_item_change, 1);
        toggleButtonsUpdateItem();
    }

    /**
    * Cancel update field or item of field
    * @param {Event} e - event data
    * @return {undefined}
    */
    function back(e) {
        if(e.delegateTarget.id == 'delete'){
            field_tab.click();
        } else {
            toggleButtonsUpdateItem()
            $(e.delegateTarget).find('.input-item input').val('')
            $(e.delegateTarget).find('input#checked').prop('checked', false)
        }
    }
		
    // Event (keyup|paste|change) set form data
    options_form.find('span').find('input, select, textarea').on('keyup paste change', function(){
      console.log('test');
        form.model[this.id] = this.value = (this.id === 'url') ? h.replaceChars(this.value, '-') : this.value;
        form.render()
    });

    // Event (keyup|paste|change) set field data. Create or update.
    $('.input-field').find('input, select').on( "keyup paste change", function(e) {
        var el = this;
        
        if(this.id === 'name'){
                
                if(!h.is(this.value) || field.body.name === this.value) {
                    clearTimeout(form.t) 
                    return;
                } 
        
                this.value = h.replaceChars(this.value);
                
                if(update_mode) {
                    
                    form.saveOnlyOneTime(function () { // async function
                    
                        form.editTableName({            
                            old_name: field.body.name,
                            new_name: el.value,
                            success: function () {
                                console.log('name changed correct');
                                field.body['name'] = el.value;
                                form.save()
                            },
                            error: function (message) {
                                $(el).next().text(message)
                                $(el).addClass('empty');
                                window.setTimeout(function(){ $(el).removeClass('empty') }, 1000)
                                window.setTimeout(function(){ $(el).next().empty() }, 5111)
                            }
                        })
                    })
                    
                } else {
                    field.body['name'] = this.value;
                    render()
                }
        } else {
            field.body[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
            if (field.body[this.id] === '') {
                delete field.body[this.id]
            }
        render()
        }
    });
	
    // Event (keyup|paste) set text to description field
	quill.on('text-change', function(delta, oldDelta, source) {
		field.body['textdescription'] = $("#" + field.body.field).find("#textdescription .ql-editor").html();
		render();
	});
			
    /**
    * Show/hide buttons (close|clone|delete) item
    */
	function toggleButtonsUpdateItem(){  
        $('#' + field.body.field).find('.input-item').toggleClass( "update" );
        render();
    }
    

    /**
    * Render form (is update) or field.
    * @return {undefined}
    */
    function render() {
        if(update_mode){
            form.render()
            renderSelectUpdateItem(field)
        } else {
            field.render()
        }
    }

    /**
    * Prevent send field object with empty property name
    * @param {event} e - event
    * @return {undefined}
    */
    function preventEmptyName(e) {
        var el = $(e.delegateTarget).find("#name");
            if(el.val() == ''){
                el.toggleClass('empty');
                window.setTimeout(function() { el.toggleClass('empty') }, 2000)
            }
        }

    /**
    * Prevent send form object without title and url
    * @param {event} e - event
    * @return {undefined}
    */
    function preventEmptyTitleUrl(e) {
        var title = $(e.delegateTarget).find("#title"),
            url = $(e.delegateTarget).find("#url");
            
            if(title.val() == ''){
                title.addClass('empty');
                window.setTimeout(function() { title.removeClass('empty') }, 2000)
            }
            
            if(url.val() == ''){
                url.addClass('empty');
                window.setTimeout(function() { url.removeClass('empty') }, 2000)
            }
            
        }
        
/**
 * Render Select input to select to update items
 * @param {Object} field 
 * @return {String} render select tag
*/			
    function renderSelectUpdateItem(field){
        	var helpers = h;
        	if(!helpers.is(field)){
        		return;
        	}
        	
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
	}

    /**
    * Set active tab
    * @param {HTMLelement} target - Delegate object
    * @return {undefined}
    */
    function activeTab(target) {
        update_mode = (target === '#update-tab')
        if(!update_mode){
            sidebar.removeClass('update')
        }
        
        select_field.removeClass('show');
        $('#tabs li.active-tab').removeClass('active-tab');
        $(target).addClass('active-tab');
    }
        
    /**
    * Set active action. Show active tab
    * @param {string} target - id of html element
    * @return {undefined}
    */
    function activeAction(target) {
        if(!$(target).hasClass('active-option')) {
             $('.active-option').removeClass('active-option');
             $(target).addClass('active-option');
        }
            
        if(field_tab.hasClass('active-tab')){
            preview_field.addClass('show');
        } else {
            preview_field.removeClass('show');
        }
    }	
};
