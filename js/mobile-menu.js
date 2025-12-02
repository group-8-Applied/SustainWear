document.addEventListener("DOMContentLoaded", function() {
	const sidebar = document.getElementById("sidebar");
	const menuBtn = document.getElementById("mobile-menu-btn");

	if (!sidebar || !menuBtn) return;

	function openSidebar() {
		sidebar.classList.remove("translate-x-full");
		menuBtn.classList.add("opacity-0", "pointer-events-none");
	}

	function closeSidebar() {
		// move it off screen, classList already contains animation
		sidebar.classList.add("translate-x-full");
		menuBtn.classList.remove("opacity-0", "pointer-events-none");
	}

	menuBtn.addEventListener("click", openSidebar);

	// tablet users with keyboard
	document.addEventListener("keydown", function(e) {
		if (e.key === "Escape" && !sidebar.classList.contains("translate-x-full")) { // if open
			closeSidebar();
		}
	});

	// close sidebar when clicking outside
	document.addEventListener("click", function(e) {
		// if tapping outside the sidebar, and it is open
		if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !menuBtn.contains(e.target) && !sidebar.classList.contains("translate-x-full")) {
			closeSidebar();
		}
	});
});
