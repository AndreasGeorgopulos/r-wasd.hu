(function () {
	const videoContainer = document.querySelector('.video-background-holder');
	const video = videoContainer.querySelector('video');

	function resizeVideo() {
		const { innerWidth, innerHeight } = window;
		const videoRatio = video.videoWidth / video.videoHeight;
		const windowRatio = innerWidth / innerHeight;
		const containerRatio = videoContainer.offsetWidth / videoContainer.offsetHeight;
		if (windowRatio < videoRatio) {
			video.style.width = 'auto';
			video.style.height = '100%';
			if ((videoContainer.offsetHeight * videoRatio) < videoContainer.offsetWidth) {
				video.style.width = '100%';
				video.style.height = 'auto';
			}
		} else {
			video.style.width = '100%';
			video.style.height = 'auto';
			if ((videoContainer.offsetWidth / videoRatio) < videoContainer.offsetHeight) {
				video.style.width = 'auto';
				video.style.height = '100%';
			}
		}
	}

	window.addEventListener('resize', resizeVideo);
	resizeVideo();
})();