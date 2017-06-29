// Copyright (c) MIT 2017 Rafal Marguzewicz pceuropa.net
var MyFORM =  MyFORM || {};
MyFORM.test = function(form){

var version = 'test: 2.0.0',
	object_form = {
    "title": "Title-test",
    "method": "get",
    "language": "Polish-test",
    'url': 'url-cos-tam',
    "body": [
        [
            {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h1>Wielki wytuł</h1><br>"
            },
            {
                "field": "input",
                "type": "text",
                "label": "Label input",
                "name": "input1",
                "placeholder": "place",
                "helpBlock": "desc input text",
                "width": "col-md-6",
                "require": true,
                "value": "value1",
                "id": "id",
                "class": "form-control"
            }
        ],
        [
            {
                "field": "radio",
                "label": "Label Radio",
                "helpBlock": "desc radio",
                "name": "radio3",
                "width": "col-md-6",
                "require": true,
                "id": "id",
                "class": "form-control",
                "items": [
                    {
                        "text": "radio1",
                        "value": "radio-value1",
                        "id": "",
                        "checked": true
                    },
                    {
                        "text": "radio2",
                        "value": "radio-value2",
                        "class": "",
                        "checked": false
                    }
                ]
            },
            {
                "field": "checkbox",
                "label": "Label Checkbox",
                "helpBlock": "desc checkbox",
                "name": "checkbox4",
                "width": "col-md-6",
                "id": "id",
                "class": "form-control",
                "items": [
                    {
                        "text": "checkbox1",
                        "value": "checkbox-value1",
                        "id": "",
                        "checked": true
                    },
                    {
                        "text": "checkbox2",
                        "value": "checkbox-value2",
                        "class": "",
                        "checked": false
                    }
                ]
            }
        ],
        [
            {
                "field": "select",
                "label": "select label",
                "helpBlock": "desc checkbox",
                "width": "col-md-6",
                "require": true,
                "id": "",
                "class": "form-control",
                "items": [
                    {
                        "text": "select1",
                        "value": "select-value1",
                        "id": "",
                        "checked": true
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    },
                    {
                        "text": "select2",
                        "value": "select-value1",
                        "class": "",
                        "checked": false
                    }
                ]
            },
            {
                "field": "description",
                "textdescription": "<h1> Lorem Ipsum </h1>jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki. <br /> Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym.",
                "width": "col-md-12",
                "id": "id"
            }
        ],
        [
            {
                "field": "input",
                "type": "text",
                "width": "col-md-6",
                "class": "form-control"
            }
        ],
        [
            {
                "field": "submit",
                "label": "Submit",
                "width": "col-md-6",
                "backgroundcolor": "btn-primary"
            }
        ]
       
    ]
}
console.log(version);
if(form){
	form.generate(object_form);
	form.deleteField(0, 1)
	form.model.body = [];
	form.generate(object_form)
	form.add(object_form.body[0][0]);
	form.add(object_form.body[2][1]);
}

return null

};
