window.addEventListener("load", function () {
	var notification=document.getElementById("notif");
	function open() {
		notification.style.display='block';
	};
	setTimeout(open,3000);

	notification.addEventListener("click", close, false);
	function close(e) {
		if (e.target.className==="close_btn") {
			e.currentTarget.style.display='none';
		}
	}
}, false);