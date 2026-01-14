/**
 * Share Module
 * - Copy link to clipboard
 */

export function initShare() {
  const copyBtn = document.getElementById('copyShareUrl');
  const urlInput = document.getElementById('shareUrl');
  
  if (!copyBtn || !urlInput) return;
  
  copyBtn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(urlInput.value);
      
      // Show feedback
      const originalText = copyBtn.textContent;
      copyBtn.textContent = copyBtn.dataset.copied || 'Copied!';
      copyBtn.classList.add('is-copied');
      
      setTimeout(() => {
        copyBtn.textContent = originalText;
        copyBtn.classList.remove('is-copied');
      }, 2000);
    } catch (err) {
      // Fallback for older browsers
      urlInput.select();
      document.execCommand('copy');
    }
  });
}
