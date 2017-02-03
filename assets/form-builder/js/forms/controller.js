'use strict';
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
// TODO



var MyFORM =  MyFORM || {};
MyFORM.controller = function(form, field){
	

	var version = '1.1.0',
		itemPointer = [], dataItem = {},
        key = 0,
		preview_form = $('#preview-form'),
		preview_field = $('#preview-field'),

		sidebar_div_options = $('#sidebar div.options'),
		options_form = $('#form'),
		
		select_field = $('select#select-field'),

		form_tab =		$('#form-tab'),
		field_tab = 	$('#field-tab'),
		udpate_tab =	$('#update-tab'),
		delete_tab =	$('#delete-tab'),
		
		update_div = $('#update'),
		delete_div = $('#delete');
		console.log('controller:', version);

//Actions:
// 1. -------- FORM -----------------
preview_form
    .delegate('.edit', 		'click', function(e){ edit(e)  })
    .delegate('.clone', 	'click', function(e){ clone(e) })
    .delegate('.delete', 	'click', function(e){ del(e)   });

// 2-1-a view-mode
 $('#tabs')
 	.on('click',    'li',    function(e){  activeTab(e.target);});  
 	
$('#view-mode')
	.change(function (){
        form.setView(this.value);
        form.render('off');
    })

sidebar_div_options
    .on('click',    '#add-to-form',         function(){  form.add(field.body); actionField(); })
    .on('mouseenter','#prevent-empty-name', function(e){ preventEmptyName(e); })
    .on('click',    '.add-item',            function(e){ addItem(e);}    )    
    .on('change',   'select.change-item',   function(e){ selectChangeItem(e)} )   
    .on('click',    '.clone-item-field',    function(e){ cloneItem(e); $('#items input').unbind(); }  )    
    .on('click',    '.delete-item-field',   function(e){ deleteItem(e); $('#items input').unbind(); } )
    .on('click',    '.back',    			function(e){ back(e); $('#items input').unbind();}) 

    
 $('#sidebar')
    .on('click',    '#form-tab',            function(){  activeAction('#form'); })   
    .on('click',    '#field-tab',           function(){  actionField() })   
   // .on('keyup change', 'input.itemField',  function(){ })  
    .on('click', 	'#save-form', function(){ form.save() })  



//Funcitions: 
 
function preventEmptyName(e) {
	var el = $(e.delegateTarget).find("#name");
			el.toggleClass('empty');
			window.setTimeout(function() { el.toggleClass('empty') }, 2000)
	}
	
	
function activeTab(target) {
			select_field.removeClass('show');
			$('#tabs li.active-tab').removeClass('active-tab');
			$(target).addClass('active-tab');
	}
	
function activeAction(target) {
		
		if(!$(target).hasClass('active-option')){
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
    
    

// not use
function helperAttribNameFields(id) {
	$('#name').val('question' + form.questions)
};

function actionField() { 
   // $('.change-item').hide();
	select_field.change();
};


select_field.change(function () {
    
		var field_selector = $('#' + this.value);
		
		select_field.addClass('show');
		activeAction(field_selector);
		window.scrollTo(0,document.body.scrollHeight);
		
        field_selector.find('.row').show();   /// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
        field_selector.find('#update-buttons').hide();

		field_selector.find('span').find('input, select, textarea').on('keyup change', 
			function() {
				field_selector.find('#add-to-form').prop( 'disabled', field_selector.find('#name').val() === '' ? true : false );
				field.body[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
				field.render();
				
			}
		);
		
		field_selector.find('#items').find('input#text').on('keyup change', 
			function() {
				field_selector.find('button.add-item').prop( 'disabled', $(this).val() === '' ? true : false );
			}
		);
		
		field =  new MyFORM.field.factory({field: this.value});
		field.uiHelper();
		field.render();

        itemPointer = field.body.hasOwnProperty('items') ? field.body.items : [];
	});
	
   function addItem(e){
        var o = {};
        
			var inputs = document.getElementById(e.delegateTarget.id).getElementsByClassName('itemField');
			for (var i = 0; i < inputs.length; i++) {
					o[inputs[i].id] = (inputs[i].type === 'checkbox') ? inputs[i].checked : inputs[i].value;
				}
        itemPointer.push(o)
        
        e.delegateTarget.id == 'update' ? form.render() : field.render();
        renderSelectUpdateItem(e);
    }

   function renderSelectUpdateItem(e) {

        var target = e.delegateTarget;
        target = (target.id == 'preview-form') ? '#update' : target;
        
        $(target).find('.select-item-to-change').html(
            (function () {
                var i = 0, temp = '', options = '';

                for (i; i < itemPointer.length; i++) {
		            temp = itemPointer[i].text ? itemPointer[i].text : '';
		            options += '<option value="' + i + '">'+(i + 1) +'. ' + temp +'</option>';
	            }

	            return '<select class="change-item form-control input-sm"><option selected>Change item</option>'+ options + '</select>';  
            })()
        );
        
    }
    
   function selectChangeItem(e){ // select item to change
        var item = itemPointer[e.currentTarget.value];
        console.log(e);
        console.log(item);
        
        toggleButtonsUpdateItem(e);
        key = e.currentTarget.value;
        
        for (var prop in item) {
            
            if(typeof item[prop] === 'string'){
				$(e.delegateTarget).find('#items').find('input#'+prop).val(item[prop]);
			} else {
			    $(e.delegateTarget).find('#items').find('input#'+prop).prop('checked', item[prop]);
			}
        }

        $(e.delegateTarget).find('#items input').on('keyup change', 
	        function() {
		        item[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
		        e.delegateTarget.id == 'update' ? form.render() : field.render();
	        }
        );
    }
    
   function cloneItem(e){
        
        var o = form.clear(itemPointer[key]);
        itemPointer.splice(key, 0, o)
        toggleButtonsUpdateItem(e);
        renderSelectUpdateItem(e);
    }

    function deleteItem(e){
        itemPointer.splice(key, 1);
        toggleButtonsUpdateItem(e);
        renderSelectUpdateItem(e);
    }

    function toggleButtonsUpdateItem(e) {  
        
        var target = e.delegateTarget;
        target = (target.id == 'preview-form') ? '#update' : target;
        
        
        console.log(e);
        $(target).find('#items').toggleClass( "update" );
        
        if(e.delegateTarget.id == 'update'){
            form.render(); // reset select-change-item
        } else {
            field.render();
        }
    }
    

    function back(e) {
    
        if(e.delegateTarget.id == 'delete'){
            field_tab.click();
        } else {
            toggleButtonsUpdateItem(e)
            $(e.delegateTarget).find('#items input').val('')
            $(e.delegateTarget).find('input#checked').prop('checked', false)
        }
    }

// EDIT FIELD in FORM
    function edit(e){
		var map = e.target.dataset, id = 0; 
        var name = form.body[map.row][map.index].name;
        field = form.body[map.row][map.index];
        
        update_div
            .html( $('#'+ field.field).html() )
            .find('#add-to-form').remove();
            
		if(field.hasOwnProperty('items')){
			itemPointer = field.items;
			
			renderSelectUpdateItem(e);
		}
			
			activeTab('#update-tab');
			activeAction(update_div);
			
			console.log(e);
			
            // set data in input
			for (var prop in field) {
            
				if (field.hasOwnProperty(prop) && prop !== 'field'){

					if(typeof field[prop] === 'string'){
						$('#update #'+ prop).val(field[prop]);
					}

					if(typeof field[prop] === 'boolean'){
						$('#update #'+ prop).prop('checked', field[prop]);
					}
				} 
			}
			
			$('#update span input, #update span select').donetyping(function(){
			  		
			  		if(this.id === 'name') {
            			if(name != this.value){ form.editName(name, this.value); }
            		} 
            		
            		field[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
				    form.render();
			}, form.time_out)
			.on('change', function (){
			 		field[this.id] = (this.type === 'checkbox') ? this.checked : this.value;
			 		form.render();
			
			 });
			
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
