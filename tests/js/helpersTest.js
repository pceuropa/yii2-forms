 "use strict";
                                                          
/**
 * .toBe()
 * .toBeCloseTo(expected, precisionopt)
 * .toEqual()
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

describe("Test helpers:",function(){

var o = {
	'var1': "string",
	'var2': null,
	'var3': undefined,
}

var o2 = {
	'var1': "string",
}
	
	it("First capitalize",function(){
		expect('String').toEqual(h.capitalizeFirstLetter('string'));
	});

	it("Clear object from null and undefined",function(){
		expect(h.clearObject(o)).toEqual(o2);
	});
	
	it("Clone object",function(){
		expect(h.clone(o)).toEqual(o);
	});
  
  
  it("fibonacci",function(){
    expect(h.fibonacci(0)).toEqual(0);
    expect(h.fibonacci(1)).toEqual(1);
    expect(h.fibonacci(2)).toEqual(1);
    expect(h.fibonacci(3)).toEqual(2);
    expect(h.fibonacci(4)).toEqual(3);
    expect(h.fibonacci(5)).toEqual(5);
    expect(h.fibonacci(6)).toEqual(8);
    expect(h.fibonacci(7)).toEqual(13);
    expect(h.fibonacci(8)).toEqual(21);
    expect(h.fibonacci(9)).toEqual(34);
    expect(h.fibonacci(10)).toEqual(55);
    expect(h.fibonacci(11)).toEqual(89);
  });
  
  it("First propery of object",function(){
    expect(h.firstProp(o)).toEqual('var1');
  });
  it("First propery of object",function(){
    expect(h.firstProp(null)).toBeFalsy();
  });
  
  
  it("First value of object",function(){
    expect("string").toEqual(h.firstValue(o));
  });
  it("First value of object",function(){
    expect(h.firstValue(h.clone())).toBe();
  });
  
  
  it("is String",function(){
		expect(h.isString('string')).toBe(true);
		expect(h.isString(false)).toBeFalsy();
		expect(h.isString({})).toBeFalsy();
		expect(h.isString()).toBeFalsy();
		expect(h.isString([])).toBeFalsy();
  });
  
  it("is",function(){
		expect(h.is('string')).toBe(true);
		expect(h.is(0)).toBe(true);
		expect(h.is(1)).toBe(true);
		expect(h.is(false)).toBe(true);
		expect(h.is({})).toBe(true);
		
		expect(h.is()).toBeFalsy();
		expect(h.is('')).toBeFalsy();
		expect(h.is(null)).toBeFalsy();
		expect(h.is(undefined)).toBeFalsy();
  });
  
  it("is Boolean",function(){
		expect(h.isBoolean('string')).toBe(false);
		expect(h.isBoolean(0)).toBe(false);
		expect(h.isBoolean(1)).toBe(false);
		expect(h.isBoolean(false)).toBe(true);
  });
  
  it("is Array",function(){
		expect(h.isArray([])).toBe(true);
		expect(h.isArray({})).toBeFalsy();
		expect(h.isArray('')).toBeFalsy();
		expect(h.isArray(o)).toBeFalsy();
		expect(h.isArray('string')).toBeFalsy();
  });
  
  
  it("is Object",function(){
		expect(h.isObject(o)).toBe(true);
		expect(h.isObject({})).toBe(true);
		expect(h.isObject([])).toBe(true); // tez object
		expect(h.isObject('string')).toBe(false);
		expect(h.isObject(0)).toBe(false);
		expect(h.isObject(1)).toBe(false);
		expect(h.isObject(false)).toBe(false);
  });
  
  it('replace char', function () {
  	expect(h.replaceChars('a b c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a-b-c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a-b-c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a/b/c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a\\b\\c')).toBe('a_b_c')
  	expect(h.replaceChars('a\\b\\c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a#b#c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('a.b.c', '-')).toBe('a-b-c')
  	expect(h.replaceChars('', '-')).toBe('')
  	expect(h.replaceChars('!@#$$%^&><:"{}')).toBe('_')
  });
  
  
  it('subString', function () {
  	expect(h.subString('Adam', 1)).toBe('A...')
  	expect(h.subString('Adam', 2)).toBe('Ad...')
  	expect(h.subString('12345678901')).toBe('1234567890...')
  	expect(h.subString('abc')).toBe('abc')
  });
  
   it('unique name', function () {
  	expect(h.uniqueName('Adam', ['Adam', 'Adam_2'])).toBe('Adam_2_2')
  });
});

