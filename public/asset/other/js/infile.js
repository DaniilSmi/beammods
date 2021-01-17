const butt = document.querySelector("#addtag1");
const butt2 = document.querySelector("#addtag2");
const area = document.querySelector("#comment_form_controller_text");

try {
	butt.onclick = function () {
		area.value = area.value + "[bigtext][bigtext/]";
	}

	butt2.onclick = function () {
		area.value = area.value + "[italictext][italictext/]";
	}

	function doArea (name, cId) {
		area.value = "[quote [name "+name+" name/], [commentId "+ cId +" commentId/]]";
		area.focus();
	}
} catch {
	
}