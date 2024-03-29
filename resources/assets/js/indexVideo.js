if ($('.video-background-holder video').length) {
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

		const indexVideo = document.getElementById("index-video");
		const sourceList = indexVideo.getElementsByTagName("source");
		const numSources = sourceList.length;
		let lastIndex = 0;

		indexVideo.onended = function() {
			lastIndex = (lastIndex + 1) % numSources;
			if (lastIndex === 0) {
				indexVideo.src = sourceList[0].src; // Az első videóval folytatódik
			} else {
				indexVideo.src = sourceList[lastIndex].src;
			}
			indexVideo.play();
		};
	})();

	(function () {
		const video = document.getElementById('index-video');
		const prevButton = document.getElementById('prev-button');
		const nextButton = document.getElementById('next-button');

		const videos = Array.from(document.querySelectorAll('#index-video source'));

		let currentVideoIndex = 0;
		video.src = videos[currentVideoIndex].src;

		prevButton.addEventListener('click', function() {
			currentVideoIndex = (currentVideoIndex - 1 + videos.length) % videos.length;
			video.src = videos[currentVideoIndex].src;
			video.play();
		});

		nextButton.addEventListener('click', function() {
			currentVideoIndex = (currentVideoIndex + 1) % videos.length;
			video.src = videos[currentVideoIndex].src;
			video.play();
		});
	})();
}