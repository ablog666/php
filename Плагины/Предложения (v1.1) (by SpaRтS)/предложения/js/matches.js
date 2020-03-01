editing = 0;

function searchMatch(id) {
 ge('progr2').style.display = '';
 var onSuccess = function(ajaxObj, responseText) {
  ge('progr2').style.display = 'none';
  ge('oneMatch').innerHTML = responseText;
  if (id > 0) {
   ge('matchMessage').innerHTML = "<div id='msg'>4</div>";
  } else if (id < 0) {
   ge('matchMessage').innerHTML = "<div id='dld'>3</div>";
  } else {
   ge('matchMessage').innerHTML = "";
  }
 };

 var onFail = function() {};
 var onCaptchaShow = function() {
  ge('progr2').style.display = 'none';
 };
 var onCaptchaHide = function() {};
 var options = {onSuccess: onSuccess, onFail: onFail, onCaptchaShow: onCaptchaShow, onCaptchaHide: onCaptchaHide};
 Ajax.postWithCaptcha('/matches.php', {'act': 'a_search', 'st': ge('current').value, 'c': ge('city').value, 's': ge('sex').value, 'y': ge('years').value, 'id': id},
   options
 );
}

function delMatch(id) {
 var ajax = new Ajax(); 
 ajax.onDone = function(ajaxObj, responseText) {
  ge('progr7').style.display = 'none';
  ge('delMatch'+id).innerHTML = responseText;
 };
 ge('progr7').style.display = '';
 ajax.post('/matches.php', {'act': 'a_sent', 'to_id': id, 'dec': 0});
}

function editQuestion() {
 if (editing == 1) {
  var question = ge('questionEdited').value;
  ge('questionText').value = question;
  ge('question').innerHTML = "<a href='javascript: editQuestion();'>редактировать</a>";
  ge('qButtons').style.display = "none";
  editing = 0;
 } else {
  editing = 1;
  qWidth = ge('question').offsetWidth + 5;
  if (qWidth > 420) {qWidth = 420;}
  if (qWidth < 200) {qWidth = 200;}
  var input = document.createElement("input");
  input.id = "questionEdited";
  input.style.width = qWidth+"px";
  ge('question').innerHTML = "";
  ge('question').appendChild(input);
  //firefox fix
  setTimeout(function(){input.value = ge('questionText').value;},50);
  ge('qButtons').style.display = "";
 }
}

function qAdd(n) {

 if (editing == 1) {
  ge('questionEdited').value = ge('qAdd'+n).innerHTML;
 }

}

function saveQuestion(hash) {
 editQuestion();
 var ajax = new Ajax(); 
 ajax.onDone = function(ajaxObj,responseText) {
  ge('progr2').style.display = 'none';
 };
 ge('progr2').style.display = '';
 ajax.post('/matches.php', {'act': 'a_save', 'question': ge('questionText').value});
}




function qClose() {
 var ajax = new Ajax(); 
 ajax.onDone = function(ajaxObj,responseText) {
  ge('progr2').style.display = 'none';
  ge('qAction').innerHTML = "<a href='javascript: qOpen();'>открыть</a>";
 };
 ge('progr2').style.display = '';
 ge('qClosed').innerHTML = "закрыто";
 ajax.post('/matches.php?act=a_close');
}

function qOpen() {
 var ajax = new Ajax(); 
 ajax.onDone = function(ajaxObj,responseText) {
  ge('progr2').style.display = 'none';
  ge('qAction').innerHTML = "<a href='javascript: qClose();'>закрыть</a>";
 };
 ge('progr2').style.display = '';
 ge('qClosed').innerHTML = "";
 ajax.post('/matches.php?act=a_open');
}

function cancelQuestion(id) {
 var question = ge('questionText').value;
 ge('questionText').value = question;
 ge('question').innerHTML = "<a href='javascript: editQuestion();'>"+question+"</a>";
 ge('qButtons').style.display = "none";
 editing = 0;
}


function reportSpam(mid) {

}
