
function topScroll() {
  if (document.scrollingElement.scrollTop < 30) {
    document.scrollingElement.scrollTop = 0;
  } else {
  document.scrollingElement.scrollTop = document.scrollingElement.scrollTop / 2;
  setTimeout(topScroll , 10);
  }
}
