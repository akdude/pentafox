let currentCorner = 0;

function goForward() {
    let child = document.getElementById("child");
    child.classList.remove('corner-'+currentCorner);
    currentCorner = (currentCorner+1)%4;
    
    let obstacleCorner = document.getElementById("obstacle");
    if (obstacleCorner) {
        if (obstacleCorner.classList.contains('corner-'+currentCorner)) {
            currentCorner = currentCorner === 2 ? currentCorner+1 : currentCorner;
        }    
    }
    child.classList.add('corner-'+currentCorner);
}

function goBack() {
    let child = document.getElementById("child");
    child.classList.remove('corner-'+currentCorner);
    currentCorner = currentCorner === 0 ? 3 : currentCorner-1;
    
    let obstacleCorner = document.getElementById("obstacle");
    if (obstacleCorner) {
        if (obstacleCorner.classList.contains('corner-'+currentCorner)) {
            currentCorner = currentCorner === 2 ? currentCorner-1 : currentCorner;
        }    
    }
    child.classList.add('corner-'+currentCorner);
}