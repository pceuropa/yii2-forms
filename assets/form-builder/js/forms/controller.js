'use strict';
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
// TODO

var MyFORM =  MyFORM || {};
MyFORM.controller = function(form, field){
	
	var version = '1.2.1',
        key_item_change = 0,
        update_mode = false,				// selectChangeItem()
		preview_form = form.div_form,
		preview_field = $('#preview-field'),
		field_selector,
		sidebar_div_options = $('#sidebar div.options'),
		options_form = form.options_form,
		
		select_field = $('select#select-field'),

		form_tab =		$('#form-tab'),
		field_tab = 	$('#field-tab'),
		udpate_tab =	$('#update-tab'),
		delete_tab =	$('#delete-tab'),
		
		update_div = $('#update'),
		delete_div = $('#delete');
		//quill = new Quill('.editor', { theme: 'snow'}),
		
		console.log('controller:', version);



Vue.use(VueHtml5Editor ,{
        hiddenModules: [
            "image",
            "full-screen",
        ]
    })
    
  var editor = new Vue({
        el: "#textdescription",
        data: {
            content: "",
        }
    })

//Actions:
// 1. -------- FORM -----------------
preview_form
    .delegate('.edit', 		'click', function(e){ edit(e)  })
    .delegate('.clone', 	'click', function(e){ clone(e) })
    .delegate('.delete', 	'click', function(e){ del(e)   });

// 2-1-a view-mode
 $('#tabs')
 	.on('click',    'li',    function(e){ activeTab(e.target);});  
 	
$('#view-mode')
	.change(function (){
        form.setView(this.value);
        form.render('off');
    })

sidebar_div_options
    .on('click',    '#add-to-form',         function(){  form.add( field.body); actionField();})
    .on('mouseenter','#prevent-empty-name', function(e){ preventEmptyName(e); })
    .on('click',    '.add-item',            function(e){ addItem(e);}    )    
    .on('change',   'select.change-item',   function(e){ selectChangeItem(e)} )   
    .on('click',    '.clone-item-field',    function(e){ cloneItem(e); $('.input-item input').unbind(); }  )    
    .on('click',    '.delete-item-field',   function(e){ deleteItem(e); $('.input-item input').unbind(); } )
    .on('click',    '.back',    			function(e){ back(e); $('.input-item input').unbind();}) 

    
 $('#sidebar')
    .on('click',    '#form-tab',            function(){  activeAction('#form'); })   
    .on('click',    '#field-tab',           function(){  select_field.change(); })   
    .on('click', 	'#save-form', function(){ form.save() })  

 
function render() {
console.log(update_mode);

	if(update_mode){
		form.render()
	} else {
		field.render()
	}
}



function preventEmptyName(e) {
	var el = $(e.delegateTarget).find("#name");
			el.toggleClass('empty');
			window.setTimeout(function() { el.toggleClass('empty') }, 2000)
	}
	
function activeTab(target) {
		update_mode = (target === '#update-tab')
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
options_form.find('span').find('input, select').donetyping(function() {
	    form[this.id] = this.value;
	    form.render();
    }, form.time_out);
    
// Field TAB
select_field.change(function () {
    
		field_selector = $('#' + this.value);
		
		select_field.addClass('show');
		activeAction(field_selector);
		window.scrollTo(0, document.body.scrollHeight - 50);
		
		field_selector.find('.input-item').removeClass( "update" );
		
		field = new MyFORM.field.factory({field: this.value});
		field.setDataFromSource();
		field.render();

	});
	
	
		
//field_selector.find('.add-item').prop('disabled', $(this).val() === '' ? true : false );

$('.input-field').find('input, select, #textdescription').donetyping(function(){
  		console.log(field)
			  		
  		if(this.id === 'name') {
			if(field.body.name != this.value){ form.editName( field.body.name, this.value); }
		} 
            		
				    
    	field.body[this.id] = (this.type === 'checkbox') ? this.checked : (this.id === 'textdescription') ? $(".content").html() : this.value;
				    
	  	field_selector.find('#add-to-form').prop( 'disabled', field_selector.find('#name').val() === '' ? true : false );
		
		render();
				    
}, form.time_out).on('change', function (){

 		field.body[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
 		
 		render();
 		
			
});
			 		
	
   function addItem(e){
    	var o = {},
    	inputs = document.getElementById(e.delegateTarget.id).getElementsByClassName('item-of-field');
		
		for (var i = 0; i < inputs.length; i++) {
		
			o[inputs[i].id] = (inputs[i].type === 'checkbox') ? inputs[i].checked : inputs[i].value;
		}
			
        field.body.items.push(o)
        
        render();
        renderSelectUpdateItem();
	}

   
   
   function renderSelectUpdateItem() {
		var f = field.body;
	if(f.items.length != 0){
        
        $("#"+ f.field).find('.select-item-to-change').html(
            (function () {
                var i = 0, temp = '', options = '';

                for (i; i < f.items.length; i++) {
		            temp = f.items[i].text ? f.items[i].text : '';
		            options += '<option value="' + i + '">'+(i + 1) +'. ' + temp +'</option>';
	            }

	            return '<select class="change-item form-control input-sm"><option selected>Change item</option>'+ options + '</select>';  
		        })()
		    );
		}
    }
    
   function selectChangeItem(e){ // select item to change
        var item = field.body.items[e.currentTarget.value];
        	key_item_change = e.currentTarget.value;
        	
        	toggleButtonsUpdateItem(e);
        
        
        for (var prop in item) {
            
            (typeof item[prop] === 'string') ? 
            	$(e.delegateTarget).find('.input-item').find('input#'+prop).val(item[prop]):
            	$(e.delegateTarget).find('.input-item').find('input#'+prop).prop('checked', item[prop]);
        }

        $(e.delegateTarget).find('.input-item input').on('keyup change', 
	        function() {
		        item[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
		        render();
	        }
        );
    }
    
	function toggleButtonsUpdateItem(e) {  
        var f = field.body;
        
        $("#"+ f.field).find('.input-item').toggleClass( "update" );
        render();
    }
    
    
   function cloneItem(e){
        
        var o = form.clear(field.body.items[key_item_change]);
        field.body.items.splice(key_item_change, 0, o)
        toggleButtonsUpdateItem(e);
        renderSelectUpdateItem();
    }

    function deleteItem(e){
        field.body.items.splice(key_item_change, 1);
        toggleButtonsUpdateItem(e);
        renderSelectUpdateItem();
    }

   
    

    function back(e) {
    
        if(e.delegateTarget.id == 'delete'){
            field_tab.click();
        } else {
            toggleButtonsUpdateItem(e)
            $(e.delegateTarget).find('.input-item input').val('')
            $(e.delegateTarget).find('input#checked').prop('checked', false)
        }
    }

// EDIT FIELD in FORM
    function edit(e){
		var field_selector, map = e.target.dataset, id = 0;
		
		
        field.body = form.body[map.row][map.index];
        
        field_selector = $("#" + field.body.field)
        console.log(field.body.field);
        console.log(field_selector);
        
        activeTab('#update-tab');
		activeAction(field_selector);
			
        field_selector.find('#add-to-form').remove();
    	
            
		if(field.body.hasOwnProperty('items')){
			renderSelectUpdateItem();
		}
			
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
				editor.content = field.body.textdescription
			}
			
			
			
			
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
	

};
