function init(isDev) {
  const grid = document.querySelector('.grid-overlay');

  if (!isDev) {
    // grid default hidden when not in dev
    grid.classList.remove('visible');
  }

  document.addEventListener('keypress', (e) => {
    const CHAR_CODE_G = 103;

    if (grid && e.charCode === CHAR_CODE_G) {
      grid.classList.toggle('visible');
    }
  });
}

export default { init };
