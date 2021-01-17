let timer = document.querySelector('.timerDownload span');
let timerAll = document.querySelector(".timerDownload");
const butt = document.querySelector(".dnb2 button");








function timerFunc() {
	let timerNow = timer.innerHTML;

	if (timerNow != 1) {
		timer.innerHTML = timer.innerHTML - 1;
	} else {
		clearInterval(timerInterval);
		timerAll.style.display = "none";
		butt.style.display = "block";
	}
}

let timerInterval = setInterval(timerFunc, 1000);

