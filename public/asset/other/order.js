// identificate the select
const select = document.querySelector(".select-css");
const vval = document.querySelector(".forfor");
const pagiArea = document.querySelector('.pagination');
let sql;

function getSelectInfo() {

    switch(select.value) {
        case 'dateNew':
            sql = 'SELECT * FROM "modScheme"."mod" ORDER BY "date_time" DESC';
            break;
        case 'dateOld':
            sql = 'SELECT * FROM "modScheme"."mod" ORDER BY "date_time"';
            break;
        case 'size':
            sql = 'SELECT * FROM "modScheme"."mod" ORDER BY "modSize" DESC';
            break;
    }
    return sql;
}


function showPagination(pages, currentPage) {
    
    const paginationTemplate = templater`<a href="javascript://" onclick="duol(${'page'})" class="firstPagiHref"><div id="pagiTypical"${'isCurrent'}>${'page'}</div></a>`;
    let number = Number(currentPage);
    let pagi = '<a href="javascript://" onclick="duol(1)" class="firstPagiHref"><div id="pagiFirst">1</div></a><a class="firstPagiHref2"><div id="pagiTypical">..</div></a>';

    switch(number) {
        case 1:
            let thisPage = {
                page: number,
                isCurrent: "class='currentPagiPage'"
            }
            pagi += paginationTemplate(thisPage);

            if (pages>=number+1) {
                let thisPage = {
                page: number + 1,
                isCurrent: ""
            }
            pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+2) {
                let thisPage = {
                page: number + 2,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+3) {
                let thisPage = {
                page: number + 3,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+4) {
                let thisPage = {
                page: number + 4,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            break;
        case 2:
            if (pages>=number-1) {
            let thisPage = {
                page: number - 1,
                isCurrent: ""
            }
            pagi += paginationTemplate(thisPage);
            }
            if (pages>=number) {
                let thisPage = {
                page: number,
                isCurrent: "class='currentPagiPage'"
            }
            pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+1) {
                let thisPage = {
                page: number + 1,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+2) {
                let thisPage = {
                page: number + 2,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+3) {
                let thisPage = {
                page: number + 3,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            break;
        default:
            if (pages>=number-2) {
            let thisPage = {
                page: number - 2,
                isCurrent: ""
            }
            pagi += paginationTemplate(thisPage);
            }
            if (pages>=number-1) {
                let thisPage = {
                page: number -1,
                isCurrent: ""
            }
            pagi += paginationTemplate(thisPage);
            }
            if (pages>=number) {
                let thisPage = {
                page: number,
                isCurrent: "class='currentPagiPage'"
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+1) {
                let thisPage = {
                page: number + 1,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            if (pages>=number+2) {
                let thisPage = {
                page: number + 2,
                isCurrent: ""
                }
                pagi += paginationTemplate(thisPage);
            }
            break;
    }
    function templater(strings, ...keys) {
    return function(data) {
        let temp = strings.slice();
        keys.forEach((key, i) => {
            temp[i] = temp[i] + data[key];
        });
        return temp.join('');
    }
};

    pagi += '<a class="firstPagiHref2"><div id="pagiTypical">..</div></a>'+'<a href="javascript://" onclick="duol('+pages+')" class="firstPagiHref"><div id="pagiEnd">'+pages+'</div></a>';
    pagiArea.innerHTML = pagi;
    return (currentPage * 7) - 7;
}


function getPagiInfo() {
    return new Promise(function (resolve, reject) {
        var request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/pagi/',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       let objects = request.responseText;
       objects = Math.ceil(objects);
       let currentPage = document.querySelector('.currentPagiPage').innerHTML;
       let result = showPagination(objects, currentPage);
       resolve(result);
      }
    }); 
    // Отправка запроса на сервер
    request.send();
});
 }


function show(obj) {
    // расшифровываем json
    vval.innerHTML = "";
    let obj1 = JSON.parse(obj);
    
     for (let i=0; i<obj1.length; i++) {
        let arrI = JSON.parse(obj1[i]['imagesArray']);
        vval.innerHTML= vval.innerHTML + '<a href="/mod/'+obj1[i]['id']+'" class="hrefCar">'+'<div class="blockTypicalCar">'+'<div class="blockTitle">МОД '+obj1[i]['title']+' ДЛЯ BEAMNG.DRIVE</div>'+'<img src="/asset/img/mod/'+arrI[0]+'" id="imageCarTipical">'+'<div class="otherContentCar">'+'<div class="someText">'+obj1[i]['textAbout']+'</div>'+'<hr>'+'<div class="infoIcons">'+'<div class="viewsCar"><img src="/asset/other/images/svg/preview.svg"> '+obj1[i]['watches']+'</div>'+'<div class="commentsCar"><img src="/asset/other/images/svg/comment.svg"> '+obj1[i]['comments']+'</div>'+'<div class="downloadsCar"><img src="/asset/other/images/svg/download.svg"> '+obj1[i]['downloads']+'</div>'+'</div>'+'<hr>'+'<a href="/downloadMod/'+obj1[i]['id']+'" id="downloadHref"><div class="donateHeaderButt secondButt"><button>Скачать</button></div></a>'+'</div>'+'</div>'+'</a>';
    }
}

function getObjects(query, limit, offset) {
    var request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/search/?query='+query+' LIMIT '+limit+' OFFSET '+offset,true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       let objects = request.responseText;
       show(objects);
      }
    }); 
    // Отправка запроса на сервер
    request.send();
}

select.onchange = function () {  
    let sql = getSelectInfo();
    let a = getPagiInfo();
    let promiseResult = a.then(result => {b = result}).then(() => getObjects(sql, 7, b));   
}


window.onload = function () {
    // собираем sql
     var request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/pagi/',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       let objects = request.responseText;
       objects = Math.ceil(objects);
       showPagination(objects, 1);
      }
    }); 
    // Отправка запроса на сервер
    request.send();

    let sql = 'SELECT * FROM "modScheme"."mod" ORDER BY "date_time" DESC';
    getObjects(sql, 7, 0);
    
}

function duol(aaa) {
    window.scrollTo(0, 800);

    let sql = getSelectInfo();

    if (aaa != 1) {
        aaa = (aaa * 7) - 7; 
    } else {
        aaa = 0;
    }

    getObjects(sql, 7, aaa);

    if (aaa == 0) {
        aaa = 1;
    } else {
        aaa = (aaa / 7) + 1;
       
    }


    var request = new XMLHttpRequest();
    // Настройка запроса
    request.open('GET','/pagi/',true);
    //request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
    request.addEventListener('readystatechange', function() {
      // если состояния запроса 4 и статус запроса 200 (OK)
      if ((request.readyState==4) && (request.status==200)) {
       let objects = request.responseText;
       objects = Math.ceil(objects);
       showPagination(objects, aaa);
      }
    }); 

    request.send();
}
