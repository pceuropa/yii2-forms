/**
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
string_body_form = {
    "body":'[[{ "field": "input", "type": "text", "width": "col-md-12", "name": "name", "label": "label", "value": "value", "require": true }]]',
}

describe("Test form:", function() {
    var form = new MyFORM.Form();
    form.init({});

    it("form.js init test", function() {
        expect(form.method).toBe("post");
        expect(form.language).toBe("en");
        expect(form.body).toEqual([]);
    });

    it("Add bad fields to form", function() {
        var add;
          add = form.add({});
          expect(form.body).toEqual([]);
          expect(add).toBeFalsy();
    });
    it("Add good fields to form", function() {
        form.add(field_input);
        expect(form.body).toEqual([[field_input]]);

        form.add(field_radio);
        expect(form.body).toEqual([[field_input], [field_radio]]);
        expect(form.body).not.toEqual([]);
    });

    it("Generate form", function() {
       form.generate(string_body_form);
       expect(form.body).toEqual([[field_input]]);
       expect(form.body).not.toEqual([[]]);
       
    });

    it("change name", function() {
      form.c.autosave = true;
      expect(form.editTableName({"old_name": "name", "new_name": "name"})).toBeFalsy();
      expect(form.editTableName({"old_name": "" ,"new_name": "name"})).toBeFalsy();
      expect(form.editTableName({"old_name": "" ,"new_name": ""})).toBeFalsy();
      expect(form.editTableName({"old_name": "good" ,"new_name": "well"})).toBe(true);
      form.c.autosave = false;
      expect(form.editTableName({"old_name": "good" ,"new_name": "well"})).toBeFalsy();
    });

    it("form filter", function() {
      expect(form.filter(field_input)).toEqual(field_input);
      expect(form.filter(field_input)).not.toEqual([]);
      expect(form.filter()).toBe(false);
    });
});
