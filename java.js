const scrollText = document.getElementById('scrollText');
function handleScroll() {
    if (window.scrollY > 0) {
    
        scrollText.style.opacity = '0';
    } else {
      
        scrollText.style.opacity = '1';
    }
}
window.addEventListener('scroll', handleScroll);
