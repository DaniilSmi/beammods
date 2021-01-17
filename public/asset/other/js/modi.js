const query = 'SELECT COUNT(*) FROM "modScheme"."mod"';
const area1478 = document.querySelector('.modInfC');


let request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/getM/?query='+query,true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       let objects = request.responseText;
       area1478.innerHTML = objects;
      }
    }); 
    // Отправка запроса на сервер
    request.send();