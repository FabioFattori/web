let matrix = []
function generateMatrix(){
    for (let i = 0; i < 6; i++) {
        let toPush  = []
        for (let j = 0; j < 7; j++) {
            let choise = Math.floor(Math.random()*2+1)
            toPush.push(choise)
        }
        matrix.push(toPush)
    }
}

function createCell(value,parent,i,j){
    let cell = document.createElement("td")
    if (value == 1) {
        cell.style.backgroundColor = "red"
    }else{
        cell.style.backgroundColor ="blue"
    }
    cell.addEventListener("click",() => {
        cell.style.backgroundColor="inherit"
        matrix[i][j] = 0;
    });
    parent.appendChild(cell)
}

function populateTable(){
    let table = document.getElementsByTagName("table")[0]
    for (let i = 0; i < matrix.length; i++) {
        let row = document.createElement("tr")
        for (let j = 0; j < matrix[i].length; j++) {
            createCell(matrix[i][j],row,i,j)
        }
        table.appendChild(row)
    }
}

function populateSecondTable(){
    let table = document.getElementsByTagName("table")[1]

    // destroy the previous values
    while(table.firstChild != null){
        table.firstChild.remove()
    }

    for (let i = 0; i < matrix.length; i++) {
        let row = document.createElement("tr")
        for (let j = 0; j < matrix[i].length; j++) {
            let cell = document.createElement("td")
            cell.innerHTML = matrix[i][j]
            row.appendChild(cell)
        }
        table.appendChild(row)
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    generateMatrix()
    populateTable()
    let button = document.getElementsByTagName("button")[0]
    console.log(button)
    button.addEventListener("click",() => {
        populateSecondTable()
    })
});