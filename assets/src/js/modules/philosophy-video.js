/**
 * Philosophy Video Player
 * Custom video player with play/pause functionality
 */

export function initPhilosophyVideo() {
  const container = document.getElementById('philosophyVideoContainer');
  const video = document.getElementById('philosophyVideo');
  const playButton = document.getElementById('playPhilosophyVideo');

  if (!video || !playButton) return;

  // Play/Pause toggle
  const togglePlay = () => {
    if (video.paused) {
      video.play();
      playButton.classList.add('is-hidden');
    } else {
      video.pause();
      playButton.classList.remove('is-hidden');
    }
  };

  // Click on play button
  playButton.addEventListener('click', (e) => {
    e.preventDefault();
    togglePlay();
  });

  // Click on video to toggle
  video.addEventListener('click', togglePlay);

  // Show play button when video ends
  video.addEventListener('ended', () => {
    playButton.classList.remove('is-hidden');
    video.currentTime = 0;
  });

  // Show play button when video is paused
  video.addEventListener('pause', () => {
    playButton.classList.remove('is-hidden');
  });

  // Hide play button when video plays
  video.addEventListener('play', () => {
    playButton.classList.add('is-hidden');
  });

  // Keyboard accessibility
  container?.addEventListener('keydown', (e) => {
    if (e.key === ' ' || e.key === 'Enter') {
      e.preventDefault();
      togglePlay();
    }
  });
}
