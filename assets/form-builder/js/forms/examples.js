var MyFORM =  MyFORM || {};
//#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

MyFORM.examples = function (form){

var version = '1.2.4',
	id_selector = "#examples-form",
	
temp = [
	{
    "title": "questionnaire",
    "method": "post",
    "language": "English",
    "body": [
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h1>Questionnaire</h1>",
                "": "1"
            },
            {
                "field": "input",
                "name": "thinking",
                "type": "text",
                "label": "what are you thinking about",
                "width": "col-md-12",
                "require": true
            },
            {
                "field": "radio",
                "width": "col-md-6",
                "items": [
                    {
                        "text": "No",
                        "value": "no",
                        "checked": true
                    },
                    {
                        "text": "Yes",
                        "value": "yes"
                    }
                ],
                "name": "trump",
                "label": "Do you like Trump?"
            },
            {
                "field": "radio",
                "width": "col-md-6",
                "items": [
                    {
                        "text": "No",
                        "value": "no",
                        "checked": true
                    },
                    {
                        "text": "Yes",
                        "value": "yes"
                    }
                ],
                "name": "eat",
                "label": "You eat meat?"
            }
        ],
        [
            {
                "field": "textarea",
                "name": "ceta",
                "width": "col-md-12",
                "label": "What do you think about CETA?",
                "require": true
            }
        ],
        [],
        [
            {
                "field": "input",
                "name": "age",
                "type": "number",
                "label": "Age",
                "width": "col-md-4",
                "require": true
            },
            {
                "field": "select",
                "width": "col-md-4",
                "items": [
                    {
                        "text": "Female",
                        "value": "female"
                    },
                    {
                        "text": "Male",
                        "value": "male"
                    },
                    {
                        "text": "I do not know",
                        "value": "0",
                        "checked": true
                    }
                ],
                "name": "sex",
                "label": "Sex"
            },
            {
                "field": "input",
                "name": "color",
                "type": "color",
                "label": "Favorite color",
                "width": "col-md-4",
                "require": true,
                "value": "#EAAE1B"
            }
        ],
        [],
        [],
        [
            {
                "field": "checkbox",
                "width": "col-md-12",
                "items": [
                    {
                        "text": "C++",
                        "value": "c"
                    },
                    {
                        "text": "Python",
                        "value": "python"
                    },
                    {
                        "text": "JavaScript",
                        "value": "javascript"
                    },
                    {
                        "text": "PHP",
                        "value": "php"
                    },
                    {
                        "text": "Fortran",
                        "value": "fortran"
                    }
                ],
                "name": "framework",
                "label": "What languages you know?"
            }
        ],
        [],
        [
            {
                "field": "submit",
                "width": "col-md-6",
                "backgroundcolor": "btn-success",
                "label": "Submit"
            }
        ]
    ]},
    {
    "title": "login",
    "method": "post",
    "language": "English",
    "body": [
        [
            {
                "field": "input",
                "type": "text",
                "width": "col-md-6",
                "name": "name",
                "label": "Email",
                "require": true
            },
            {
                "field": "input",
                "name": "pass",
                "type": "text",
                "label": "Password",
                "width": "col-md-6",
                "require": true
            }
        ],
        [],
        [
            {
                "field": "checkbox",
                "width": "col-md-12",
                "items": [
                    {
                        "text": "Remember me",
                        "checked": true,
                        "value": 1
                    }
                ],
                "name": "remember"
            }
        ],
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<p><a target=\"_blank\" href=\"https://pceuropa.net/blog/\">I forgot my password.</a></p>",
                "": "https://pceuropa.net/blog/"
            }
        ],
        [
            {
                "field": "submit",
                "width": "col-md-12",
                "backgroundcolor": "btn-info",
                "label": "Submit"
            }
        ]
    ],
},
{
    "title": "Comments",
    "method": "post",
    "language": "English",
    "body": [
        [
            {
                "field": "textarea",
                "width": "col-md-12",
                "rows": "5",
                "name": "comment",
                "placeholder": "",
                "label": "Comment"
            }
        ],
        [
            {
                "field": "input",
                "type": "text",
                "width": "col-md-6",
                "name": "name",
                "label": "Name"
            },
            {
                "field": "input",
                "type": "email",
                "width": "col-md-6",
                "name": "email",
                "label": "Email",
                "placeholder": "Email address will not be published"
            }
        ],
        [],
        [
            {
                "field": "submit",
                "width": "col-md-12",
                "backgroundcolor": "btn-success",
                "label": "Post Comment"
            }
        ]
    ]
},
{
    "title": "Event",
    "method": "post",
    "language": "English",
    "body": [
        [],
        [
            
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h1 class=\"ql-align-center\">Event friends Yii2</h1><h2 class=\"ql-align-center\">4-7 April 2017 </h2><p class=\"ql-align-center\">(registration is open until 21 March 2017) </p><p class=\"ql-align-center\">"
            },
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h2>Personal data</h2>"
            },
            {
                "field": "input",
                "name": "name",
                "type": "text",
                "label": "Name",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "email",
                "type": "email",
                "label": "E-mail",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "birth",
                "type": "date",
                "label": "Date of birth",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "id",
                "type": "text",
                "label": "Identity Card number",
                "width": "col-md-6",
                "require": true
            }
        ],
        [],
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<p><em>Your responses will be kept confidential and anonymous.</em></p>"
            }
        ],
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h2>Data organization</h2>"
            },
            {
                "field": "input",
                "name": "name_org",
                "type": "text",
                "label": "Name of the organization",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "address",
                "type": "text",
                "label": "Address",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "phone",
                "type": "tel",
                "label": "Phone",
                "width": "col-md-6",
                "require": true
            }
        ],
        [],
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h2>Hotel reservation</h2>",
                "": "2"
            }
        ],
        [
            {
                "field": "radio",
                "name": "room",
                "label": "I book room",
                "width": "col-md-12",
                "require": true,
                "items": [
                    {
                        "text": "1-bedded",
                        "value": "1",
                        "checked": true
                    },
                    {
                        "text": "no thanks",
                        "value": "0"
                    }
                ]
            },
 
        ],
        [
            {
                "field": "textarea",
                "label": " Comments",
                "width": "col-md-12",
                "rows": "3",
                "value": " ",
                "name": "comments"
            }
        ],
        [],
        [
            {
                "field": "checkbox",
                "width": "col-md-12",
                "items": [
                    {
                        "text": "I agree to the processing of personal data",
                        "value": 1,
                        "checked": true
                    },
                    {
                        "text": "I like spam. Need more",
                        "value": 2,
                        "checked": true
                    }
                ],
                "name": "processing",
                "require": true
            }
        ],
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<p>Thank you ... lorem .... Procrastination ... ble ble</p>"
            },
            {
                "field": "submit",
                "width": "col-md-12",
                "backgroundcolor": "btn-primary",
                "label": "Submit"
            }
        ],
        [],
        [],
        []
    ],
    "url": "wizyta-studyjna",
    "response": "Thank you for your registration, You are on the list submitted to the event"
}
];

var div1 = document.createElement("div"),

	innerHTML = '<label class="col-sm-3 control-label">Examples</label>' +
				'<div class="col-sm-6">' +
				'<select id="examples-form" class="form-control"><option>-</option> </select>'+
				'</div><div id="section-confirm"></div>';
	
	
				
	(function(){
			div1.setAttribute('class', 'row form-group-sm');
			div1.innerHTML = innerHTML;
		
			$(div1).find(id_selector).append( function() {
				var option, t, options = document.createElement('div');
			
				h.each(temp, function (i) {
					t = temp[i];
					option = document.createElement('option');
					h.setAttribute(option, 'value', i);
					option.appendChild(document.createTextNode(t.title));
					options.appendChild(option);
				})
				return options.innerHTML;
			})
			
			window.setTimeout(function() {
			if(form.body.length) return;
				
			
				$("#form #widget-form-options").append( div1.outerHTML ).on( "change", id_selector, function() {
							var value = this.value;
							$("#section-confirm").empty().html( '<button id="confirm-example" type="button" class="btn btn-sm btn-warning">Confirm</button>' );
							$("#confirm-example").click(function () {
								form.body = temp[value].body
								form.render()
								$("#section-confirm").empty()
							})
				});
			}, 500)
				
	})()
	
	console.log('template: ' + version);
	return temp;
};
		
		
		/*
		
<div class="form-group">
	<label class="col-sm-4 control-label">Template</label>
	<div class="col-sm-8">
		<select id="template" class="form-control input-sm">
			<option value="1">template 1</option>
		</select>
	</div>
</div>
	*/	
		
	


