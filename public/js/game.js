function move (nature) {
    let child = document.getElementById("child");
    let obstacle = document.getElementById("obstacle");
    childPosition =  child.getAttribute('data-position');
    
    if (obstacle) {
        obstaclePosition =  obstacle.getAttribute('data-position');
        obstacleCorner = obstaclePosition;
    }
    
    currentCorner = childPosition;
    
    child.classList.remove('corner-'+currentCorner);
    
    if (nature > 0) {
        currentCorner = (parseInt(currentCorner)+nature)%4;
        if (obstacle) {
            if (currentCorner == parseInt(obstacleCorner)) {
                currentCorner = (currentCorner+1)%4;
            }
        }
    } else {
        currentCorner = (parseInt(currentCorner)+nature)%4;
        currentCorner = currentCorner < 0 ? currentCorner+4 : currentCorner;
        if (obstacle) {
            if (currentCorner == parseInt(obstacleCorner)) {
                currentCorner = currentCorner-1;
            }
        }
    }
    child.classList.add('corner-'+currentCorner);
    child.setAttribute('data-position',currentCorner);
}