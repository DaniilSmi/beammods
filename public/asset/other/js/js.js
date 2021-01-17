let animation = true;
let body = document.querySelector('body');
function openLogin() {
	animation = true;
	let window = document.querySelector('.loginWindow');
	if (window.style.transform != "translateY(0px)") {
		window.style.transform = "translateY(50px)";
		window.style.transition = "transform .25s ease";
		body.style.overflowY = 'hidden';
	}
	
	function goTrue() {
		if(!animation) return false;
		window.style.transform = "translateY(0)";
		anim_stop();
	}

	window.addEventListener("transitionend", goTrue, false);
}

function closeLogin() {
	body.style.overflowY = 'scroll';
	let window = document.querySelector('.loginWindow');
	window.style.transition = "transform .5s linear";
	window.style.transform = "translateY(-1000px)";
}


function anim_stop() {
animation = false;
}


