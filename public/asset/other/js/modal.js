//инициализируем нужные переменные
window.onload = function () {
let modal = document.querySelectorAll('.modalImage');
let MyModal = document.querySelector("#MyModal");
let modalImage = document.querySelector('.modal-content');
let body45 = document.querySelector('body');
let pr = document.querySelector("#modalPrevImage");
let nx = document.querySelector("#modalNextImage");
let tracker = document.querySelector("#idIgmModal");

// показываем окно изображения
function showModal(i) {
	try {
		// вытаскиваем ссылку из картинки
		let src = modal[i].getAttribute('src');
		// добавляем ссылку на нужуню картинку
		modalImage.setAttribute('src', src);
		// показываем окно
		MyModal.style.display="block";
		// убираем прокрутку
		body45.style.overflowY = 'hidden';
		// задаём значение для идентификатора 
		tracker.innerHTML = i;
	} catch (err) {

	}
	
}

for (let i = 0; i < modal.length; i++) {
	modal[i].onclick = function () {
		
		showModal(i);
	}		
}

function closeModalFn() {
	MyModal.style.display = "none";
	body45.style.overflowY = 'scroll';
}

document.getElementById('closeModal').onclick  = function () {
	closeModalFn();
}


pr.onclick = function () {
	let id = tracker.innerHTML;
	if (id-1 >= 0) {
		showModal(Number(id)-1);
	}
	
}

nx.onclick = function () {
	let id = tracker.innerHTML;
	showModal(Number(id)+1);
}

document.addEventListener('keydown', function(event) {
  if (event.key == 'Escape') {
  	closeModalFn();
  }
});


document.addEventListener('keydown', function(event) {
  if (event.key == 'ArrowRight') {
  	if (MyModal.style.display == "block") {
  		let id = tracker.innerHTML;
			showModal(Number(id)+1);
  	}
  }
});


document.addEventListener('keydown', function(event) {
  if (event.key == 'ArrowLeft') {
  	if (MyModal.style.display == "block") {
  		let id = tracker.innerHTML;
			showModal(Number(id)-1);
  	}
  }
});

}