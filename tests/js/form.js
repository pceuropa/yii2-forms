describe("Test helpers:",function(){
var form = new MyFORM.Form();
	form.init({});
	it("First capitalize",function(){
		expect(form.title).toBe("FormBuilder");
		expect(form.method).toBe("post");
		expect(form.language).toBe("English");
		expect(form.t).toBe(null);
		expect(form.tn).toBe(null);
	});

});

