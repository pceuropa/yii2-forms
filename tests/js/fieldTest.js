

describe("Test field: input", function() {

var input = {
                "field": "input",
                "type": "text",
                "width": "col-md-12",
                "name": "name",
                "label": "label",
                "value": "value",
                "require": true
            },
field_outerHTML = '<div class="form-group col-md-12"><label>label *</label><input value="value" require="true" name="name" type="text"></div>',
field_input = new MyFORM.field.factory(input),
field = field_input.html();

    it("check htmlElement - input", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.firstChild.localName).toBe("label");
       expect(field.childElementCount).toBe(2);
       expect(field.outerHTML).toBe(field_outerHTML)
    });


})

describe("Test field: textarea", function() {

var data = {
                "field": "textarea",
                "width": "col-md-12",
                "name": "name",
                "label": "label",
                "value": "value",
                "require": true,
                "helpBlock": "description"
            },
field_input = new MyFORM.field.factory(data),
field_outerHTML = '<div class="form-group col-md-12"><label>label *</label><textarea require="true" name="name">value</textarea>description</div>',
field = field_input.html();

    it("check textarea", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.firstChild.localName).toBe("label");
       expect(field.childElementCount).toBe(2);
       expect(field.outerHTML).toBe(field_outerHTML)
       expect(field.lastChild.textContent).toBe("description");
    });


})

describe("Test field: radio", function() {
var data = {
                "field": "radio",
                "width": "col-md-12",
                "items": [
                    { "text": "item1", "value": 1 },
                    { "text": "item2", "value": 2 },
                    { "text": "item3", "checked": true, "value": 3 }
                ],
                "name": "radio",
                "label": "radio",
                "helpBlock": "description"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("radio", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.firstChild.localName).toBe("label");
       expect(field.childElementCount).toBe(4);
       expect(field.lastChild.textContent).toBe("description");
    });

})


describe("Test field: select", function() {

var data = {
                "field": "select",
                "width": "col-md-12",
                "items": [
                    { "text": "item1", "value": 1 },
                    { "text": "item2", "value": 2 },
                    { "text": "item3", "selected": true, "value": 3 }
                ],
                "name": "selected",
                "label": "selected",
                "helpBlock": "description"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("select", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.firstChild.localName).toBe("label");
       expect(field.childElementCount).toBe(2);
       expect(field.children[1].localName).toBe("select");
       expect(field.children[1][0].localName).toBe("option");
       expect(field.lastChild.textContent).toBe("description");
       console.log(field);
    });

})
describe("Test field: checkbox", function() {

var data = {
                "field": "checkbox",
                "width": "col-md-12",
                "items": [
                    { "text": "item1", "value": 1 },
                    { "text": "item2", "checked": true, "value": 3 }
                ],
                "name": "checkbox",
                "label": "checkbox",
                "helpBlock": "description"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("check htmlElement - checkbox", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.firstChild.localName).toBe("label");
       expect(field.childElementCount).toBe(3);
       expect(field.lastChild.textContent).toBe("description");
    });

})

describe("Test field: description", function() {

var data = {
                "field": "description",
                "width": "col-md-12",
                "textdescription": "<h1>description</h1>",
                "id": "id",
                "class": "class"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("check htmlElement - description", function() {
       expect(field.className).toBe("class col-md-12"); 
       expect(field.childElementCount).toBe(1);
       expect(field.outerHTML).toBe('<div class="class col-md-12" id="id"><h1>description</h1></div>')
    });

})

describe("Test field: button with label", function() {

var data = {
                "field": "submit",
                "width": "col-md-12",
                "label": "submit",
                "backgroundcolor": "btn-primary"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("check htmlElement - description", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.childElementCount).toBe(1);
       expect(field.outerHTML).toBe('<div class="form-group col-md-12"><button class="btn btn-primary">submit</button></div>')
    });

})

describe("Test field: button without label", function() {

var data = {
                "field": "submit",
                "width": "col-md-12",
                "backgroundcolor": "btn-primary",
                "id": "id",
                "class": "class"
            },
field =  new MyFORM.field.factory(data);
field = field.html();

    it("check htmlElement - description", function() {
       expect(field.className).toBe("form-group col-md-12"); 
       expect(field.childElementCount).toBe(1);
       expect(field.outerHTML).toBe('<div class="form-group col-md-12"><button class="btn btn-primary class" id="id"></button></div>')
    });

})
