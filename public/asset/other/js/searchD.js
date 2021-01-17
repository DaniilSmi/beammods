try {
	const search = document.querySelector('#searchSite');
	const btt = document.querySelector('#submitSearchSite');

	btt.onclick = function () {
		window.location.href = '/searchMod/q/' + search.value;
	}
} catch {
	
}
