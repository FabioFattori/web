let oldElementSelected = null;

function createTable(){
    let main = document.getElementsByTagName("main")[0];
    let table = document.createElement("table");
    let tBody = document.createElement("tbody")
    table.id = "numeri";
    let row = document.createElement("tr")
    
    for (let i = 1; i < 10; i++) {
        let cell = document.createElement("td")
        cell.innerText= i;
        cell.addEventListener("click",()=>{
            let output =document.getElementsByClassName("log")[0]
            if(oldElementSelected  == null){
                output.innerText = "Cella non selezionata"
                return
            }

            console.log(oldElementSelected.innerText)
            oldElementSelected.innerText = cell.innerText
            oldElementSelected.style.backgroundColor = "inherit"
            oldElementSelected = null
            output.innerText = "Numero inserito correttamente"
        })
        row.appendChild(cell)
    }
    tBody.appendChild(row)
    table.appendChild(tBody)
    main.appendChild(table)
}

function addEventListenersToTable(){
    let table = document.getElementsByClassName("tabellone")[0]
    let body = table.getElementsByTagName("tbody")[0]
    for (let i = 0; i < body.children.length; i++) {
        let singleTr = body.children[i]
        for (let j = 0; j < singleTr.children.length; j++) {
            singleTr.children[j].addEventListener("click",(element)=>{
                let flag = false;
                //check if backgroundColor is #cacaca
                if(singleTr.children[j].style.backgroundColor == "rgb(202, 202, 202)"){
                    singleTr.children[j].style.backgroundColor = "inherit"
                    flag = true
                }else{
                    singleTr.children[j].style.backgroundColor = "#cacaca"
                }

                if(oldElementSelected!= null && singleTr.children[j] != oldElementSelected){
                    oldElementSelected.style.backgroundColor = "inherit"
                }
                oldElementSelected = singleTr.children[j]
                
                if(flag){
                    oldElementSelected = null
                }
            })
        }
    }
}

document.addEventListener("DOMContentLoaded",()=>{
    createTable();
    addEventListenersToTable();
});