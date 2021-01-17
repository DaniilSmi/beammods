function showComments(arr) {
	let commArea = document.querySelector('.commentsArea');

	arr.forEach(function callback(curVal, i, array) {
		let cl = "";
    let pr = array[i]['id'];

		if (array[i]['isAnswer'] == true) {
			 cl = "replyCommentStyles";
       pr = array[i]['parent_id'];
		} 

		commArea.innerHTML += '<div class="comment '+cl+'"><img class="userImgComment" src="/asset/img/user/'+array[i]['img_url']+'"><div class="commentInfo"><div class="userName"><span>'+array[i]['user_name']+'</span></div><div class="dateComm"><span>'+array[i]['datetime']+'</span></div><div class="replyComment"><a href="javascript://" onclick="doArea(`'+array[i]['user_name']+'`, `'+pr+'`)">Ответить</a></div><br><div class="commentText"><p>'+array[i]['text']+'</p></div></div></div>';
	});
}


function getComments(id) {
	let request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/getComments/?page='+id,true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       	let object = request.responseText;
       	let object2 = JSON.parse(object);
				showComments(object2);
      }
    }); 
    // send ajax

    request.send();
}