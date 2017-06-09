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
                "require": true,
                "class": "form-control",
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
                "class": "form-control",
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
                "class": "form-control",
                "label": "Age",
                "width": "col-md-4",
                "require": true
            },
            {
                "field": "select",
                "width": "col-md-4",
                "class": "form-control",
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
                "class": "form-control",
                "label": "Favorite color",
                "width": "col-md-4",
                "require": true,
                "value": "#EAAE1B"
            }
        ],
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
        [
            {
                "field": "submit",
                "width": "col-md-6",
                "backgroundcolor": "btn-success",
                "label": "Submit"
            }
        ]
    ]},{
    "title": "wiara",
    "method": "post",
    "language": "en",
    "body": [
        [
            {
                "field": "input",
                "name": "wiek",
                "class": "form-control",
                "type": "number",
                "label": "Ile masz lat ?",
                "width": "col-md-4"
            },
            {
                "field": "input",
                "type": "number",
                "width": "col-md-4",
                "class": "form-control",
                "name": "dzieci",
                "label": "Ile masz dzieci ?",
                "require": true
            },
            {
                "field": "select",
                "name": "wyksztalcenie",
                "label": "Wykształcenie",
                "class": "form-control",
                "width": "col-md-4",
                "items": [
                    {
                        "text": "podstawowe",
                        "value": "podstawowe"
                    },
                    {
                        "text": "gimnazjalne",
                        "value": "gimnazjalne"
                    },
                    {
                        "text": "zasadnicze",
                        "value": "zasadnicze"
                    },
                    {
                        "text": "średnie",
                        "value": "średnie"
                    },
                    {
                        "text": "wyższe",
                        "value": "wyższe"
                    }
                ],
                "require": true
            }
        ],
        [
            {
                "field": "radio",
                "width": "col-md-3",
                "items": [
                    {
                        "text": "Tak",
                        "value": "tak"
                    },
                    {
                        "text": "Nie",
                        "value": "nie"
                    }
                ],
                "name": "wiara_w_boga",
                "label": "Czy wieżysz w boga ?"
            },
            {
                "field": "textarea",
                "width": "col-md-9",
                "class": "form-control",
                "name": "chrzest_uzasadnij",
                "label": "Czy możesz uzasadnic tą decyzję ?",
                "rows": "4"
            }
        ],
        [
            {
                "field": "radio",
                "width": "col-md-3",
                "items": [
                    {
                        "text": "Tak",
                        "value": "tak"
                    },
                    {
                        "text": "Nie",
                        "value": "nie"
                    }
                ],
                "name": "chrzest",
                "label": "Czy chrzciłeś swoje dzieci ?",
                "require": true
            },
            {
                "field": "textarea",
                "width": "col-md-9",
                "class": "form-control",
                "name": "wiara_boga_uzasadij",
                "label": "Czy możesz uzasadnic tą decyzję ?",
                "rows": "4"
            }
        ],
        [
            {
                "field": "select",
                "width": "col-md-9",
                "class": "form-control",
                "items": [
                    {
                        "text": "2 000 000 >",
                        "value": "2000000+"
                    },
                    {
                        "text": "1 000 000 - 2 000 000",
                        "value": "1000000-2000000"
                    },
                    {
                        "text": "700 000 - 1 000 000",
                        "value": "700000-1000000"
                    },
                    {
                        "text": "200 000 - 700 000",
                        "value": "200000-700000"
                    },
                    {
                        "text": "50 000 - 200 000",
                        "value": "50000-200000"
                    },
                    {
                        "text": "10 000 - 50 000",
                        "value": "10000-50000"
                    },
                    {
                        "text": "5 000 - 10 000",
                        "value": "5000-10000"
                    },
                    {
                        "text": "1000 - 5000",
                        "value": "1000-5000"
                    },
                    {
                        "text": "< 1000",
                        "value": "<1000"
                    }
                ],
                "name": "miasto",
                "label": "Liczba mieszkańców twojego miasta mieści się w przedziale ?"
            }
        ],
        [
            {
                "field": "submit",
                "width": "col-md-12",
                "class": "form-control",
                "backgroundcolor": "btn-primary",
                "label": "Wyślij"
            }
        ],
    ],
    "author": 1,
    "date_start": "2017-05-29",
    "date_end": null,
    "maximum": null,
    "meta_title": "",
    "url": "wiara",
    "response": "",
},
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
                "class": "form-control",
                "name": "name",
                "label": "Email",
                "require": true
            },
            {
                "field": "input",
                "name": "pass",
                "type": "text",
                "class": "form-control",
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
                "class": "form-control",
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
                "class": "form-control",
                "width": "col-md-6",
                "name": "name",
                "label": "Name"
            },
            {
                "field": "input",
                "type": "email",
                "class": "form-control",
                "width": "col-md-6",
                "name": "email",
                "label": "Email",
                "placeholder": "Email address will not be published"
            }
        ],
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
                "class": "form-control",
                "label": "Name",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "email",
                "type": "email",
                "class": "form-control",
                "label": "E-mail",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "birth",
                "type": "date",
                "class": "form-control",
                "label": "Date of birth",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "id",
                "type": "text",
                "class": "form-control",
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
                "class": "form-control",
                "label": "Name of the organization",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "address",
                "type": "text",
                "class": "form-control",
                "label": "Address",
                "width": "col-md-6",
                "require": true
            },
            {
                "field": "input",
                "name": "phone",
                "type": "tel",
                "class": "form-control",
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
                "class": "form-control",
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
			if(form.model.body.length) return;
				
			
				$("#form #widget-form-options").append( div1.outerHTML ).on( "change", id_selector, function() {
							var value = this.value;
							$("#section-confirm").empty().html( '<button id="confirm-example" type="button" class="btn btn-sm btn-warning">Confirm</button>' );
							$("#confirm-example").click(function () {
								form.model.body = temp[value].body
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
		
	


