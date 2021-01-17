

function showImages(arr) {
  let arrUse = JSON.parse(arr);
  let fia = document.querySelector('.fImage');
  let coi = document.querySelector('.containerOtherImages');
  

  /*arrUse.forEach((key, i) => {
    if (i = 0) {
      fia.innerHTML = '<img id="firstImage" class="modalImage" src="/asset/img/mod/'+arrUse[0]+'">';
    } else {
      alert(i);
      coi.innerHTML = coi.innerHTML + '<img class="modalImage gridS" src="/asset/img/mod/'+arrUse[i]+'">';
    } 
  });*/

  for(i=0; i<arrUse.length; i++) {
    if (i == 0) {
      fia.innerHTML = '<img id="firstImage" class="modalImage" src="/asset/img/mod/'+arrUse[0]+'">';
    } else {
      
      coi.innerHTML = coi.innerHTML + '<img class="modalImage gridS" src="/asset/img/mod/'+arrUse[i]+'">';
    }
  }
}



function setLike (id) {
    let request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/sql/?query=1&id='+id,true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
      // get butt span
      let area = document.querySelector('.likesInButt'); 
       let object = request.responseText;
      

       switch (object){
          case "p":
            area.innerHTML = Number(area.innerHTML) + 1;
            break; 
          case "m":
            area.innerHTML = Number(area.innerHTML) - 1;
            break;
          default:
            alert("Вы не авторизованы!");
       }
        
      }
    }); 
    // send ajax

    request.send();
  
  }

