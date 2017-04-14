'use strict';
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

var MyFORM =  MyFORM || {};
MyFORM.controller = function(form, field){
	
	var version = '1.2.5',
        key_item_change = 0,
        update_mode = false,				// selectItemToChange()
		preview_form = form.div_form,
		preview_field = $('#preview-field'),
		field_selector,
		sidebar = $('#sidebar'),
		sidebar_div_options = $('#sidebar div.options'),
		options_form = form.options_form,
		
		select_field = $('select#select-field'),

		form_tab =		$('#form-tab'),
		field_tab = 	$('#field-tab'),
		udpate_tab =	$('#update-tab'),
		delete_tab =	$('#delete-tab'),
		
		update_div = $('#update'),
		delete_div = $('#delete'),
		clipboard = new Clipboard('#copy-json');
		//quill = new Quill('.editor', { theme: 'snow'}),
		
		console.log('controller:', version);


var quill = new Quill('#textdescription', {
    theme: 'snow',
       modules: {
        'toolbar': [
          [{ 'header': [1, 2, false] }],
          [ 'bold', 'italic',],
          [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'align': [] }],
          [ 'link'],
          [ 'clean' ]
        ],
      },
  });



//Actions:
// 1. -------- FORM -----------------
preview_form
    .on('click',	'.edit', 	function(e){ edit(e)  })
    .on('click',	'.clone', 	 function(e){ clone(e) })
    .on('click',	'.delete', 	 function(e){ del(e)   })
    .on('click',	'button', 	 function(e){ e.preventDefault(); 
    
    var button = $(this), clone = button.clone();
    	button.text('edit mode');
    	window.setTimeout(function() {button.replaceWith(clone);}, 1111)
   });

// 2-1-a view-mode
 	
$('#view-mode')
	.change(function (){
        form.setView(this.value);
        form.render('off');
    })


		
sidebar_div_options
    .on('click',    '#add-to-form',         function(){ form.add( field.body) })
    .on('click',    '.add-item',            function(){ addItem() }    ) 
       
    .on('change',   '.change-item',   		function(e){ selectItemToChange(e)} )   
    .on('click',    '.clone-item-field',    function(e){ cloneItem(e); $('.input-item input').unbind() }  )    
    .on('click',    '.delete-item-field',   function(e){ deleteItem(e); $('.input-item input').unbind() } )
    .on('click',    '.back',    			function(e){ back(e); $('.input-item input').unbind() }) 
    
    .on('mouseenter','#prevent-empty-name', function(e){ preventEmptyName(e) })
    .on('mouseenter','#widget-form-options', function(e){ preventEmptyTitleUrl(e) })

 $('#sidebar')
    .on('click',    '#form-tab',            function(e){ activeTab(e.target); activeAction('#form') })   
    .on('click',    '#field-tab',           function(e){ activeTab(e.target); select_field.change() })   
    .on('click', 	'#save-form', function(){ form.save() })  

 
function render() {
	if(update_mode){
		form.render()
		h.renderSelectUpdateItem(field)
	} else {
		field.render()
	}
}


function preventEmptyName(e) {
	var el = $(e.delegateTarget).find("#name");
		if(el.val() == ''){
			el.toggleClass('empty');
			window.setTimeout(function() { el.toggleClass('empty') }, 2000)
		}
			
	}
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
	
function activeTab(target) {

		update_mode = (target === '#update-tab')
		if(!update_mode){
			sidebar.removeClass('update')
		}
		
		select_field.removeClass('show');
		$('#tabs li.active-tab').removeClass('active-tab');
		$(target).addClass('active-tab');
	}
	
	
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


// FORM TAB
options_form.find('span').find('input, textarea').on('keyup paste change', function(){

	    form[this.id] = this.value = (this.id === 'url') ? h.replaceChars(this.value, '-') : this.value;
	    form.render()
    });
    
    
// Field TAB
select_field.change(function () {
    
		field_selector = $('#' + this.value);
		
		select_field.addClass('show');
		activeAction(field_selector);
		
		window.scrollTo(0, document.body.scrollHeight - 50);
		
		field_selector.find('.input-item').removeClass( "update" );
		
		field = new MyFORM.field.factory({field: this.value});
		field.setDataFieldFrom("data-source")  // class
		field.render();

	});

		
//field_selector.find('.add-item').prop('disabled', $(this).val() === '' ? true : false );

$('.input-field').find('input, select').on( "keyup paste change", function(e) {
   var el = this;
	
	if(this.id === 'name'){
			
			if(!h.is(this.value) || field.body.name === this.value) {
				clearTimeout(form.t) 
				return;
			} // poszukac sposobu prevent name jak inne 
	
        	this.value = h.replaceChars(this.value);
        	
        	if(update_mode) {
    			
    			form.saveOnlyOneTime(function () {
    			
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
    		render();
        }
    
    
});
	
	
	quill.on('text-change', function(delta, oldDelta, source) {
		field.body['textdescription'] = $("#" + field.body.field).find("#textdescription .ql-editor").html();
		render();
	});
			
	
   function addItem(){
        var o = field.setDataItemFrom('item-of-field'); // class
        field.addItem(field, o);
        render();
	}
   
   function selectItemToChange(e){ // select item to change
        var item = field.body.items[e.currentTarget.value],
        	el = $(e.delegateTarget).find('.input-item');
        
        	key_item_change = e.currentTarget.value;
        	console.log(key_item_change);
        	
        	toggleButtonsUpdateItem();
        
        for (var prop in item) {
            
            (h.isBoolean( item[prop]) ) ?
            	el.find('input#' + prop).prop('checked', item[prop]):
            	el.find('input#' + prop).val(item[prop]);
        }

        $(e.delegateTarget).find('.input-item input').on('keyup change', 
	        function() {
		        item[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
		        render();
	        }
        );
    }
    
	function toggleButtonsUpdateItem(){  
        $('#' + field.body.field).find('.input-item').toggleClass( "update" );
        render();
    }
    
	function cloneItem(e){
        
        var o = form.clear(field.body.items[key_item_change]);
        o.value = field.body.items.length + 1
        field.body.items.push(o)
        toggleButtonsUpdateItem();
    }

    function deleteItem(e){
        field.body.items.splice(key_item_change, 1);
        toggleButtonsUpdateItem();
    }

    function back(e) {
    
        if(e.delegateTarget.id == 'delete'){
            field_tab.click();
        } else {
            toggleButtonsUpdateItem()
            $(e.delegateTarget).find('.input-item input').val('')
            $(e.delegateTarget).find('input#checked').prop('checked', false)
        }
    }

// EDIT FIELD in FORM
    function edit(e){
		var field_selector, map = e.target.dataset, id = 0;
		
		sidebar.addClass( "update" );
		
        field.body = form.body[map.row][map.index];
        
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
			
		h.renderSelectUpdateItem(field)	
			// $('#update span').find('input, textarea, select').on('keyup change', function (){});
            
	}

// CLone FIELD in Form
	function clone(e){
		var map = e.target.dataset;	
			form.cloneField(map.row, map.index);
	}


// Del FIELD in Form
	function del(e){
		var map = e.target.dataset;

			activeTab(delete_tab);
			activeAction('#delete');

		$('button#btn-delete-confirm').unbind().click(function () {
			form.deleteField(map.row, map.index);
			form.render();
			field_tab.click();
			
		});	

	}
	
	

    clipboard.on('success', function(e) {
       $('#copy-json').text('Copied!').fadeOut().fadeIn(100, function () {
       	$('#copy-json').text('Copy')
       });
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

};
