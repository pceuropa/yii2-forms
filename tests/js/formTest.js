/**
 * Test for form.js
 * @author Rafal Marguzewicz
 * @license MIT
 * @return {undefined}
 *
 * .toBe()
 * .toBeCloseTo(expected, precisionopt)
 * .toEqual() // Equal object
 * .toBeDefined() - "The 'toBeDefined' matcher compares against `undefined`"
 * .toBeUndefined()
 * .toBeFalsy()
 * .toBeGreaterThan(expected)
 * .toBeGreaterThanOrEqual(expected)
 * .toBeLessThan(expected)
 * .toBeLessThanOrEqual(expected)
 * .toBeNan()
 * .toBeNull()
 * .toBeTruthy()
 * .toBeLessThanOrEqual(expected)
 * .toHaveBeenCalled()
 * .toHaveBeenCalledBefore()
 * .toHaveBeenCalledTimes(3)
 * .toHaveBeenCalledWith()
 * .toMatch()
 * .toThrow()
*/
console.log("FormTest: 1.0.0");

var field_input = {
                "field": "input",
                "type": "text",
                "width": "col-md-12",
                "name": "name",
                "label": "label",
                "value": "value",
                "require": true
            },
field_radio = {
                "field": "radio",
                "width": "col-md-12",
                "items": [
                    { "text": "item1", "value": 1 },
                    { "text": "item2", "value": 2 },
                    { "text": "item3", "checked": true, "value": 3 }
                ],
                "name": "radio",
                "label": "radio"
            },
body_form = {
    "url": "testurl",
    "title": "testtitle",
    "maximum": 30,
    "date_end": "2017-12-31",
    "action": "index.php",
    "id": "testid",
    "method": "get",
    "class": "testclass",
    "body":'[[{ "field": "input", "type": "text", "width": "col-md-12", "name": "name", "label": "label", "value": "value", "require": true }]]',
}

describe("Test1 form: init", function() {
    var form = new MyFORM.Form();
    form.init({"autosave": true});
    form.setView('text');

    it("Generate form", function(){ 
        form.generate(body_form);
        expect(form.model.body).toEqual([[field_input]]);
        expect(form.model.title).toBe("testtitle");
        expect(form.model.url).toBe("testurl");
        expect(form.model.maximum).toBe(30);
        expect(form.model.date_end).toBe("2017-12-31");
        expect(form.model.action).toBe("index.php");
        expect(form.model.class).toBe("testclass");
        expect(form.model.method).toBe("get");
        expect(form.model.language).toBe("en");
    });

    it("form init", function() {
        expect(form.c.autosave).toBe(true);
        expect(form.c.get).toBe(false);
    });

    it("Add bad field", function() {
        var add = form.add({});
        expect(add).toBeFalsy();
    });

});

describe("Test2 form: add delete delete add add", function() {
    var form2 = new MyFORM.Form();
    form2.init({"autosave": true});
    form2.setView('text');

    it("Add field", function() {
        form2.add(field_input);
        expect(form2.model.body).toEqual([[field_input]]);
    });


    it("delete field", function() {
        var delSuccess= form2.deleteField(0,0); 
        expect(delSuccess).toBe(true);
        delSuccess= form2.deleteField(0,0); 
        expect(delSuccess).toBe(false);
    });

    it("Add field and unique name", function() {
        var field_copy = field_input;
        field_copy.name = field_input.name + '_2';
        form2.add(field_input);
        expect(form2.model.body).toEqual([[], [field_input]]);

        form2.add(field_input);
        expect(form2.model.body[2]).toEqual( [field_copy]);
    });
});

describe("Test3 form: change table names", function() {
    var form = new MyFORM.Form();
    form.init({"autosave": true});
    form.viewMode = 'text';

    it("change name", function() {
      expect(form.editTableName({"old_name": "name", "new_name": "name"})).toBe(false);
      expect(form.editTableName({"old_name": "" ,"new_name": "name"})).toBe(false);
      expect(form.editTableName({"old_name": "" ,"new_name": ""})).toBe(false);
      expect(form.editTableName({"old_name": "good" ,"new_name": "well"})).toBe(true);
      form.c.autosave = false;
      expect(form.editTableName({"old_name": "good" ,"new_name": "well"})).toBe(false);       // if autosace is false editTableName() return false

    });

    it("form filter", function() {
      expect(form.filter(field_input)).toEqual(field_input);
      expect(form.filter()).toBe(false);
    });
});

describe("Test3 form: add clone delete add clone", function() {
    var form = new MyFORM.Form(),
        field = { "field": "input", "type": "text", "width": "col-md-12", "name": "name", "label": "label", },
        field2 = { "field": "input", "type": "text", "width": "col-md-12", "name": "name_2", "label": "label_2", },
        field3 = { "field": "input", "type": "text", "width": "col-md-12", "name": "name_2_2", "label": "label_2", };

    form.init({"autosave": true});
    form.viewMode = 'text';
    form.add(field);                                    // 1 field name

    it("clone field", function() {
        var field = form.model.body[0][0];
        form.cloneField(0,0);                           // 2 fields name_2
        expect(form.model.body[0][1]).toEqual(field2);
        form.deleteField(0,1)                           // 1 fields 
        form.add(field);                                // 2 fields name_2
        form.cloneField(1,0)                            // 3 fileds name_2_2
        expect(form.model.body[1][1]).toEqual(field3);
    });

});
