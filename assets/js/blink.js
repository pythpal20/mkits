function blinkText() {
    var tx = document.getElementById('blink');
    setInterval (function() {
        tx.style.visibility = (tx.style.visibility == 'hidden' ? '' : 'hidden');
    }, 1000);
}