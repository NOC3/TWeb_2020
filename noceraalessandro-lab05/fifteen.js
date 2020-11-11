var free_tile = "";
var moves = 0;
var tiles = [];
var MAX_MOVES = 100;

window.onload = start;

function start(){
    tiles = document.getElementById("puzzlearea").getElementsByTagName("div");
    var t_counter = 0;
    for(var i = 0; i<4; i++){
        for(var j = 0; j<4; j++){
            if(t_counter<15){
                setPos(tiles[t_counter],i,j);
                setImg(tiles[t_counter],i,j);
                //set passaggio sopra con mouse
                tiles[t_counter].onmouseover = over;
                tiles[t_counter].onmouseleave = leave;
                //set click 
                tiles[t_counter].onclick = move;
            }
            t_counter = t_counter + 1;
        }       
    }
    this.free_tile = "t_3_3";

    var shufflebutton = document.getElementById("shufflebutton");
    shufflebutton.onclick = shuffle;
    shufflebutton.innerHTML = "Shuffle";
    moves = 0;
}

function setPos(element, riga, colonna){
    id = "t_"+riga+"_"+colonna;
    element.setAttribute("id", id);
}

function setImg(element, riga, colonna){
    var pos = String(-(colonna*100))+"px "+String(-(riga*100))+"px";
    element.style.backgroundPosition = pos;
}

function move(){
    var id = this.id;
    if(isMovable(this.id)){
        this.setAttribute("id", free_tile);
        free_tile = id;
        moves = moves +1;
    } 
    check();
}

function parsePos(str){
    var a = str[2]+str[4];
    return a;
}

function over(){
    if(isMovable(this.id)){
        this.style.borderColor = "red";
        this.style.color = "red";
    }
}
function leave(){
    this.style.borderColor = "black";
    this.style.color = "black";
}

function isMovable(str){
    var offset = Math.abs(parsePos(str)-parsePos(free_tile));
    if(offset == 1 || offset ==10){
        return 1;
    }else{
        return 0;
    }
}




function shuffle(){
    //genero numero random di mosse
    var moves = parseInt(Math.random() * MAX_MOVES);
    console.log("moves: "+moves);
    var ids = ["t_0_0","t_0_1","t_0_2","t_0_3","t_1_0","t_1_1","t_1_2","t_1_3","t_2_0","t_2_1","t_2_2","t_2_3","t_3_0","t_3_1","t_3_2","t_3_3"];
    while(moves >0){
        var pos = [];
        for(var i = 0; i<ids.length; i++){
            if(isMovable(ids[i])){
                pos.push(ids[i]);
            }
        }   
        var index = parseInt(Math.random() * pos.length);
        var element_id = pos[index];
        tmp = free_tile;
        free_tile = element_id;
        document.getElementById(element_id).setAttribute("id", tmp);
        moves = moves-1
    }
}

function check(){
    var ids = ["t_0_0","t_0_1","t_0_2","t_0_3","t_1_0","t_1_1","t_1_2","t_1_3","t_2_0","t_2_1","t_2_2","t_2_3","t_3_0","t_3_1","t_3_2","t_3_3"];
    for(var i = 0; i<tiles.length; i++){
        if(tiles[i].id != ids[i]){
            return undefined;
        }
    }
    win();
}


function win(){
    //scollegamento azioni
    for(i = 0; i< tiles.length; i++){
        tiles[i].onmouseover = undefined;
        tiles[i].onmouseleave = undefined;
        tiles[i].onclick = undefined;

    }
    
    //create new elements
    var win_message = document.createElement("p");
    win_message.setAttribute("id", "win_msg");
    win_message.innerHTML = "COMPLIMENTI!<br>hai vinto in "+moves+" mosse";
    win_message.style.fontSize = "30pt";
    win_message.style.fontWeight = "bold";
    
    //cambio elementi in controls
    var controls = document.getElementById("controls");

    controls.appendChild(win_message);
    var shufflebutton = document.getElementById("shufflebutton");
    shufflebutton.innerHTML = "NEW GAME";
    shufflebutton.onclick = start_w;
}

function start_w(){
    var controls = document.getElementById("controls");
    controls.removeChild(document.getElementById("win_msg"));
    start();
}