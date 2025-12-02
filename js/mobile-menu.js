const MOBILE_THRESHOLD = 1024; // viewport width to be considered mobile

document.addEventListener("DOMContentLoaded", function() {
	const sidebar = document.getElementById("sidebar");
	const menuBtn = document.getElementById("mobile-menu-btn");

	if (!sidebar || !menuBtn) return;

	function updateSidebarTransform() {
		if (window.innerWidth < MOBILE_THRESHOLD) closeSidebar();
		else openSidebar();
	}

	// adapt sidebar on window resize
	updateSidebarTransform();
	window.addEventListener("resize", updateSidebarTransform);

	function openSidebar() {
		// remove transform
		sidebar.style.transform = "translateX(0)";
		// hide menu button
		menuBtn.classList.add("opacity-0", "pointer-events-none");
	}

	function closeSidebar() {
		// add transform (move it off-screen)
		sidebar.style.transform = "translateX(100%)";
		// show menu button
		menuBtn.classList.remove("opacity-0", "pointer-events-none");
	}

	// open sidebar when tapping menu button
	menuBtn.addEventListener("click", openSidebar);

	// tablet users with keyboard
	document.addEventListener("keydown", function(e) {
		if (e.key === "Escape" && sidebar.style.transform === "translateX(0px)") { // if open
			closeSidebar();
		}
	});

	// close sidebar when clicking outside
	document.addEventListener("click", function(e) {
		// if tapping outside the sidebar, and it is open
		if (window.innerWidth < MOBILE_THRESHOLD && !sidebar.contains(e.target) && !menuBtn.contains(e.target) && sidebar.style.transform === "translateX(0px)") {
			closeSidebar();
		}
	});

	// close when rotating
	window.addEventListener("orientationchange", closeSidebar);
});
