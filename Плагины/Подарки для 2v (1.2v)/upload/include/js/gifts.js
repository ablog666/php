function js_buy(form, exchange, coeff, what)
{
  var doc = document.forms[form];
  
  var sum = doc.elements[form+'[sum]'].value;
  sum = parseFloat(sum.replace(/,/g, '.'));
  
  var buy = doc.elements[form+'[buy]'].value;
  buy = parseFloat(buy.replace(/,/g, '.'));
  
  var exchange = parseFloat(exchange);
  
  switch(parseInt(what))
  {
    case 1:
      if(isNaN(sum)) doc.elements[form+'[buy]'].value = '0.00';
      else doc.elements[form+'[buy]'].value = parseFloat(Math.floor(sum * coeff / exchange * 100) / 100).toFixed(2);
    break;
    
    case 2:
      if(isNaN(buy)) doc.elements[form+'[sum]'].value = '0.00';
      else doc.elements[form+'[sum]'].value = parseFloat(Math.ceil(buy * exchange / coeff * 100) / 100).toFixed(2);
    break;
  }
}