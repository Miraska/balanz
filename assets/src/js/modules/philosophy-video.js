/**
 * Philosophy Video Player
 * Custom video player with play/pause functionality
 * Supports: uploaded video files, YouTube, and Vimeo
 */

export function initPhilosophyVideo() {
  const container = document.getElementById("philosophyVideoContainer");
  const video = document.getElementById("philosophyVideo");
  const playButton = document.getElementById("playPhilosophyVideo");
  const embedPlaceholder = document.getElementById("videoEmbedPlaceholder");

  if (!playButton || !container) return;

  // Check if we have an external video URL
  const externalVideoUrl = container.dataset.videoUrl;

  // If external video URL is provided
  if (externalVideoUrl && embedPlaceholder) {
    playButton.addEventListener("click", (e) => {
      e.preventDefault();
      loadExternalVideo(
        externalVideoUrl,
        container,
        playButton,
        embedPlaceholder
      );
    });
    return;
  }

  // If no video element (only poster), just hide play button on click
  if (!video) {
    playButton.addEventListener("click", (e) => {
      e.preventDefault();
      playButton.classList.add("is-hidden");
    });
    return;
  }

  // Play/Pause toggle for uploaded videos
  const togglePlay = () => {
    if (video.paused) {
      video.play();
      playButton.classList.add("is-hidden");
    } else {
      video.pause();
      playButton.classList.remove("is-hidden");
    }
  };

  // Click on play button
  playButton.addEventListener("click", (e) => {
    e.preventDefault();
    togglePlay();
  });

  // Click on video to toggle
  video.addEventListener("click", togglePlay);

  // Show play button when video ends
  video.addEventListener("ended", () => {
    playButton.classList.remove("is-hidden");
    video.currentTime = 0;
  });

  // Show play button when video is paused
  video.addEventListener("pause", () => {
    playButton.classList.remove("is-hidden");
  });

  // Hide play button when video plays
  video.addEventListener("play", () => {
    playButton.classList.add("is-hidden");
  });

  // Keyboard accessibility
  container?.addEventListener("keydown", (e) => {
    if (e.key === " " || e.key === "Enter") {
      e.preventDefault();
      togglePlay();
    }
  });
}

/**
 * Load external video (YouTube or Vimeo) into iframe
 */
function loadExternalVideo(url, container, playButton, placeholder) {
  const embedUrl = getEmbedUrl(url);

  if (!embedUrl) {
    console.warn("Unsupported video URL:", url);
    return;
  }

  // Create iframe
  const iframe = document.createElement("iframe");
  iframe.src = embedUrl;
  iframe.width = "100%";
  iframe.height = "100%";
  iframe.frameBorder = "0";
  iframe.allow =
    "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
  iframe.allowFullscreen = true;
  iframe.style.position = "absolute";
  iframe.style.top = "0";
  iframe.style.left = "0";
  iframe.style.width = "100%";
  iframe.style.height = "100%";
  iframe.style.borderRadius = "inherit";

  // Hide placeholder and play button
  placeholder.style.display = "none";
  playButton.classList.add("is-hidden");

  // Insert iframe
  container.appendChild(iframe);
}

/**
 * Convert video URL to embed URL
 */
function getEmbedUrl(url) {
  // YouTube
  const youtubeMatch = url.match(
    /(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/
  );
  if (youtubeMatch) {
    return `https://www.youtube.com/embed/${youtubeMatch[1]}?autoplay=1&rel=0`;
  }

  // Vimeo
  const vimeoMatch = url.match(
    /(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/
  );
  if (vimeoMatch) {
    return `https://player.vimeo.com/video/${vimeoMatch[1]}?autoplay=1`;
  }

  // If already an embed URL, return as is with autoplay
  if (
    url.includes("youtube.com/embed/") ||
    url.includes("player.vimeo.com/video/")
  ) {
    const separator = url.includes("?") ? "&" : "?";
    return url + separator + "autoplay=1";
  }

  return null;
}
