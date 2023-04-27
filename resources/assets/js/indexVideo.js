(function () {
	const video = document.querySelector('.video-background-holder video');

	function resizeVideo() {
		const { innerWidth, innerHeight } = window;
		const videoRatio = video.videoWidth / video.videoHeight;
		const windowRatio = innerWidth / innerHeight;
		if (windowRatio < videoRatio) {
			video.style.width = 'auto';
			video.style.height = '100%';
		} else {
			video.style.width = '100%';
			video.style.height = 'auto';
		}
	}

	window.addEventListener('resize', resizeVideo);
	resizeVideo();
})();